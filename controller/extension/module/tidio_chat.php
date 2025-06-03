<?php

require __DIR__ . '/../../../../system/library/tidio_chat/vendor/autoload.php';

use TidioChatExtension\CreateProjectServiceFactory;
use TidioChatExtension\Exceptions\CannotCreateProjectException;
use TidioChatExtension\OpencartConst;
use TidioChatExtension\ProjectDetails;
use TidioChatExtension\TranslatorFactory;
use TidioChatExtension\UrlGeneratorFactory;

class ControllerExtensionModuleTidioChat extends Controller
{
    public function index(): void
    {
        $this->load->language(OpencartConst::MODULE_PATH);
        $this->document->setTitle($this->language->get('heading_title'));

        $privateKey = $this->getPrivateKey();

        if (!$privateKey) {
            try {
                $projectDetails = $this->createProject();

                $privateKey = $projectDetails->getPrivateKey();
            } catch (CannotCreateProjectException $e) {
                $this->prepareViewWithError($e);

                return;
            }
        }

        $this->response->redirect($this->getRedirectUrl($privateKey));
    }

    private function getPrivateKey(): ?string
    {
        $this->load->model('setting/setting');

        $privateKey = $this->config->get(OpencartConst::PRIVATE_KEY_SETTING);

        if ($privateKey) {
            return $privateKey;
        }

        return null;
    }

    private function getRedirectUrl($privateKey): string
    {
        return UrlGeneratorFactory::create()->getRedirectUrl($privateKey);
    }

    private function updateSettings(string $publicKey, string $privateKey): void
    {
        $this->model_setting_setting->editSetting(OpencartConst::SETTING_NAME, [
            OpencartConst::PUBLIC_KEY_SETTING => $publicKey,
            OpencartConst::PRIVATE_KEY_SETTING => $privateKey,
        ]);
    }

    private function clearSettings(): void
    {
        $this->updateSettings('', '');
    }

    /**
     * @throws CannotCreateProjectException
     */
    private function createProject(): ProjectDetails
    {
        $serverName = $_SERVER['SERVER_NAME'];
        $userEmail = $this->config->get('config_email');
        $ip = $_SERVER['REMOTE_ADDR'];

        $createProjectService = CreateProjectServiceFactory::create();

        try {
            $projectDetails = $createProjectService->create($serverName, $userEmail, $ip);
        } catch (CannotCreateProjectException $e) {
            $this->clearSettings();

            throw $e;
        }


        $this->updateSettings($projectDetails->getPublicKey(), $projectDetails->getPrivateKey());

        return $projectDetails;
    }

    private function prepareViewWithError(Exception $e): void
    {
        $this->document->addStyle('view/stylesheet/tidio_chat.css');

        $data['header'] = $this->load->controller('common/header');
        $data['leftMenu'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $data['tidioTranslator'] = TranslatorFactory::buildForController($this);
        $data['errorMessage'] = $e->getMessage();
        $data['extensionUrl'] = $this->url->link(
            'marketplace/extension&type=module',
            'user_token=' . $this->session->data['user_token'],
            true
        );

        $this->response->setOutput($this->load->view(OpencartConst::MODULE_PATH, $data));
    }
}
