<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;

include_once $_SERVER["DOCUMENT_ROOT"]."/local/php_interface/classes/ajax/msgHandBook.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/local/php_interface/classes/ajax/lib/favorite.php";

/**
 * @var array $templateData
 * @var array $arParams
 * @var string $templateFolder
 * @global CMain $APPLICATION
 */

global $APPLICATION;

$arOffer = $arResult["OFFERS"][$arResult["OFFER_ID_SELECTED"]];

//seo fields
$rsIProps = new \Bitrix\Iblock\InheritedProperty\ElementValues($arParams["LINK_IBLOCK_ID"],$arResult["OFFERS"][$arResult["OFFER_ID_SELECTED"]]["ID"]);
$arIPropValues = $rsIProps->getValues();
if ($arIPropValues["ELEMENT_META_TITLE"]) {
    $APPLICATION->SetPageProperty("title", $arIPropValues["ELEMENT_META_TITLE"]);
}
if ($arIPropValues["ELEMENT_META_KEYWORDS"]) {
    $APPLICATION->SetPageProperty("keywords", $arIPropValues["ELEMENT_META_KEYWORDS"]);
}
if ($arIPropValues["ELEMENT_META_DESCRIPTION"]) {
    $APPLICATION->SetPageProperty("description", $arIPropValues["ELEMENT_META_DESCRIPTION"]);
}
if ($arIPropValues["ELEMENT_PAGE_TITLE"]) {
    $APPLICATION->SetTitle($arIPropValues["ELEMENT_PAGE_TITLE"]);
}
//end

if (!empty($templateData['TEMPLATE_LIBRARY']))
{
	$loadCurrency = false;

	if (!empty($templateData['CURRENCIES']))
	{
		$loadCurrency = Loader::includeModule('currency');
	}

	CJSCore::Init($templateData['TEMPLATE_LIBRARY']);
	if ($loadCurrency)
	{
		?>
		<script>
			BX.Currency.setCurrencies(<?=$templateData['CURRENCIES']?>);
		</script>
		<?
	}
}

// check compared state
if ($arParams['DISPLAY_COMPARE']) :?>
    <script>obCatalogElement.initCompare(<?=array_key_exists($arOffer['ID'], $_SESSION[$arParams['COMPARE_NAME']][$arParams['IBLOCK_ID']]['ITEMS']) ? "true" : "false"?>);</script>
<?endif;
//end

// check favorite
?>
<script>obCatalogElement.initFavorite(<?=\kDevelop\Ajax\Favorite::isAdded($arResult["ID"]) ? "true" : "false"?>);</script>
<?
//end

//Характеристики, наличие, доставка
$afterTmp = "catalog_element_after";
if ($arParams["DEVICE_TYPE"] == "TABLET") {
    $afterTmp .= "-tablet";
} elseif ($arParams["DEVICE_TYPE"] == "MOBILE") {
    $afterTmp .= "-mobile";
}
$APPLICATION->IncludeComponent(
    "kDevelop:blank",
    $afterTmp,
    array(
        "OFFER" => $arResult["OFFERS"][$arResult["OFFER_KEY"]],
        "ELEMENT_ID" => $arResult["ID"],
        "ELEMENT_PROPERTIES" => $arResult["PROPERTIES"],
        "PROPERTY_CODE" => $arParams["PROPERTY_CODE"],
        'USE_MIN_AMOUNT' =>  $arParams['USE_MIN_AMOUNT'],
        'STORE_PATH' => $arParams['STORE_PATH'],
        'MIN_AMOUNT' => $arParams['MIN_AMOUNT'],
        'STORES' => $arParams['STORES'],
        'SHOW_EMPTY_STORE' => $arParams['SHOW_EMPTY_STORE'],
        'SHOW_GENERAL_STORE_INFORMATION' => $arParams['SHOW_GENERAL_STORE_INFORMATION'],
        'USER_FIELDS' => $arParams['USER_FIELDS'],
        'FIELDS' => $arParams['FIELDS'],
    )
);
//end

//форма "Запрос цены"
?>
<div id="price-order" class="popup">
    <div class="popup_wrapper">
        <div class="popup_content js-popup_content">
            <a href="#" class="popup_content-close" data-popup-close><i class="icon close"></i></a>
            <?$APPLICATION->IncludeComponent(
                "bitrix:form.result.new",
                "get-price",
                [
                    "SEF_MODE" => "N",
                    "WEB_FORM_ID" => WEB_FORM_GET_PRICE,
                    "LIST_URL" => "",
                    "EDIT_URL" => "",
                    "SUCCESS_URL" => "",
                    "CHAIN_ITEM_TEXT" => "",
                    "CHAIN_ITEM_LINK" => "",
                    "IGNORE_CUSTOM_TEMPLATE" => "Y",
                    "USE_EXTENDED_ERRORS" => "Y",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "3600",
                    "AJAX_MODE" => "Y",
                    "AJAX_OPTION_SHADOW" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "AJAX_OPTION_HISTORY" => "N",
                    "FIELD_VALUES" => [
                        "product" => $arResult["OFFERS"][$arResult["OFFER_ID_SELECTED"]]["NAME"]
                    ]
                ]
            );?>
        </div>
    </div>
</div>
<?//end

//форма "Купить в 1 клик"
if (isset($arResult["OFFERS"][$arResult["OFFER_ID_SELECTED"]])) :?>
<div id="buy-one-click" class="popup">
    <div class="popup_wrapper">
        <div class="popup_content js-popup_content">
            <a href="#" class="popup_content-close" data-popup-close><i class="icon close"></i></a>
            <?$APPLICATION->IncludeComponent(
                "bitrix:form.result.new",
                "buy-one-click",
                [
                    "SEF_MODE" => "N",
                    "WEB_FORM_ID" => WEB_FORM_BUY_ONE_CLICK,
                    "LIST_URL" => "",
                    "EDIT_URL" => "",
                    "SUCCESS_URL" => "",
                    "CHAIN_ITEM_TEXT" => "",
                    "CHAIN_ITEM_LINK" => "",
                    "IGNORE_CUSTOM_TEMPLATE" => "Y",
                    "USE_EXTENDED_ERRORS" => "Y",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "3600",
                    "AJAX_MODE" => "Y",
                    "AJAX_OPTION_SHADOW" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "AJAX_OPTION_HISTORY" => "N",
                    "FIELD_VALUES" => [
                        "product_id" => $arResult["OFFERS"][$arResult["OFFER_ID_SELECTED"]]["ID"]
                    ]
                ]
            );?>
        </div>
    </div>
</div>
<?endif
//end?>