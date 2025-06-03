<?php

class ModelExtensionModuleSkuGenerator extends Model {

  private $start;
  private $group;
  private $digit;

  public function __construct($registry)
  {
    parent::__construct($registry);
    $this->start = $this->config->get('sku_generator_start');
    if (empty($this->start) && $this->start !== '0')
      $this->start = 100000;
    else
      $this->start = (int)$this->start;
    $this->group = $this->config->get('sku_generator_group');
    $this->digit = (bool)$this->config->get('sku_generator_digit');

  }


/**
 * Return sku for next product, based on getting last sku. Useful for filling a field 'sku' with ajax query.
 * Возвращает отформатированный артикул для следующего продукта, который можно отображать в админке при добавлении товара, или добавлять в базу. Базируется на получении  последнего добавленного в базу артикула. Полезно для заполнения поля "артикул" при помощи ajax запроса.
 * @return [string] [Отформатированный артикул]
 */
  public function getSku () 
  {

    $intSku = $this->getNextSku();
    $sku = $this->formatIntSkuToCustom($intSku);
    return $sku;
  } 

  /**
   * Generate for all products SKU by format
   * Генерирует для всех продуктов артикул по заданному формату. Перед использованием - обязательный бэкап.
   * @return [boolean]     [true/false в зависимости от результата запроса]
   */
      public function generateAllSku()
  { 
    if($this->digit) {
      $result = $this->db->query("UPDATE `" . DB_PREFIX . "product`,
    (SELECT @sku := $this->start - 1) as skustart
    SET `sku` = 
    CONCAT_WS('-',
    IF('$this->group' = '', NULL, '$this->group'),
          REPLACE(
              FORMAT(@sku := @sku + 1, 0), ',','-'
          )
        )
      ");
        } else {        
          $result = $this->db->query("UPDATE `" . DB_PREFIX . "product`,
    (SELECT @sku := $this->start - 1) as skustart
    SET `sku` = 
    CONCAT_WS('-',
    IF('$this->group' = '', NULL, '$this->group'),
          @sku := @sku + 1
        )
      ");
              }

  if(!$result) 
    return false;
  else
    return true;
  }

  /**
   * Get last insert SKU and increment it to one for return next supposed SKU.
   * Метод получает последний вставленный артикул продукта и увеличивает его на 1 - тем самым возвращает предполагаемый следующий артикул. 
   * @return [int] [следущий ID]
   */
  private function getNextSku ()
  {
      $allSku = $this->db->query("SELECT `sku`  FROM `" . DB_PREFIX . "product`");

      if(!$allSku->rows)
        return $this->start;

      $introw = [];
      foreach ($allSku->rows as $row) {
        $intRow[] = $this->formatCustomSkuToInt($row['sku']);
      }
      $lastSku = max($intRow);
      $intSku = $lastSku + 1;
      return (int)$intSku;
  } 

  /**
   * Formatting Sku 
   * Форматирует артикул в соответствии с настройками
   * @param  [int] $intSku [Целочисленный артикул без букв]
   * @return [string]     [Форматированный артикул]
   */
    private function formatIntSkuToCustom($intSku)
  { 
     if($this->digit) {
        $sku = number_format($intSku, 0, 0, '-');
      } else {
         $sku = $intSku;
      }
      if ($this->group) {
          $customSku = $this->group . '-' . $sku;      
      } else {
          $customSku = $sku;     
      }
      return $customSku;
  }

  /**
   * Formating custom view of Sku (string) to integer
   * Форматирует пользовательский вид артикула в виде сточки в целочисленную переменную
   * @param  [string] $customSku [Артикул в пользовательском формате]
   * @return [int]               [Артикул - число]
   */
  private function formatCustomSkuToInt($customSku)
  {

    $count = 1;
    $skuWithoutGroup = str_replace($this->group . '-', '', $customSku, $count);
    $intSku = (int)preg_replace("/[^0-9]/", '', $skuWithoutGroup);
    return $intSku;
  }


  /**
   * Метод не используется в данной версии программы
   * Update SKU in DB. Use to update DB in case the user clear SKU field, or ajax doesn't work.
   * Обновление артикула в базе. Используется, если пользователь оставил поле артикула пустым, а также если не сработал ajax при заполении поля. Для лучшего понимания использования смотри модифицированый файл admin/model/catalog/product.php .
   * @param  [string] $sku        [Артикул]
   * @param  [int] $product_id [ID конкретного продукта]
   * @return [boolean]          [true/false в зависимости от результата запроса]
   */
    private function updateSku($sku, $product_id)
  {
     if ($this->db->query("UPDATE " . DB_PREFIX . "product SET sku = '" . $this->db->escape($sku) . "' WHERE product_id = ' " . (int)$product_id . " ' " )) {
      return true;
     } else {
      return false;
     }
  }
}
