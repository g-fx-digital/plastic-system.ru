<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetPageProperty("keywords", "");
$APPLICATION->SetPageProperty("description", "");
$APPLICATION->SetPageProperty("title", "Избранное - Складские лотки и пластиковая тара от компании ООО «Пластик Система»");
$APPLICATION->SetTitle("Избранное");
$APPLICATION->SetPageProperty("header_section-class", "section");

if (isset($_SESSION["FAVORITE"]) && count($_SESSION["FAVORITE"]) > 0) {
    //подготовка парметров компонента
    if (DEVICE_TYPE == "DESKTOP") {
        $itemsInRow = 5;
        $itemsInRowInner = 4;
        $elemsInRow = 5;
        $pageElemCount = 12;
        $pagerTmp = ".default";
    } elseif (DEVICE_TYPE == "TABLET") {
        $itemsInRow = 3;
        $itemsInRowInner = 2;
        $elemsInRow = 2;
        $pageElemCount = 12;
        $pagerTmp = ".default-mobile";
    } else {
        $itemsInRow = $itemsInRowInner = $elemsInRow = 1;
        $pageElemCount = 10;
        $pagerTmp = ".default-mobile";
    }
    $arImageSize = ["WIDTH" => 175, "HEIGHT" => 116];
    //end

    //сортировка и внешний вид
    //TODO: сортировка не работает
    $tmp = "catalog_controls";
    if (DEVICE_TYPE != "DESKTOP") {
        $tmp .= "-".strtolower($arParams["DEVICE_TYPE"]);
    }
    $APPLICATION->IncludeComponent(
        "kDevelop:blank",
        $tmp,
        array(
            "SORT" => $arSort
        )
    );
    //end

    //каталог
    $GLOBALS["arrFilter"] = [
        "ID" => $_SESSION["FAVORITE"]
    ];
    $APPLICATION->IncludeComponent(
        "bitrix:catalog.section",
        "",
        Array(
            "ACTION_VARIABLE" => "action",
            "ADD_PICT_PROP" => "MORE_PHOTO",
            "ADD_PROPERTIES_TO_BASKET" => "Y",
            "ADD_SECTIONS_CHAIN" => "N",
            "ADD_TO_BASKET_ACTION" => "ADD",
            "AJAX_MODE" => "N",
            "AJAX_OPTION_ADDITIONAL" => "",
            "AJAX_OPTION_HISTORY" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "BACKGROUND_IMAGE" => "UF_BACKGROUND_IMAGE",
            "BASKET_URL" => "/personal/basket.php",
            "BRAND_PROPERTY" => "BRAND_REF",
            "BROWSER_TITLE" => "-",
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "Y",
            "CACHE_TIME" => "36000000",
            "CACHE_TYPE" => "A",
            "COMPATIBLE_MODE" => "Y",
            "CONVERT_CURRENCY" => "Y",
            "CURRENCY_ID" => "RUB",
            "CUSTOM_FILTER" => "",
            "DATA_LAYER_NAME" => "dataLayer",
            "DETAIL_URL" => "",
            "DISABLE_INIT_JS_IN_COMPONENT" => "N",
            "DISCOUNT_PERCENT_POSITION" => "bottom-right",
            "DISPLAY_BOTTOM_PAGER" => "Y",
            "DISPLAY_TOP_PAGER" => "N",
            "ELEMENT_SORT_FIELD" => "PROPERTY_CML2_ARTICLE",
            "ELEMENT_SORT_FIELD2" => "id",
            "ELEMENT_SORT_ORDER" => "asc",
            "ELEMENT_SORT_ORDER2" => "desc",
            "ENLARGE_PRODUCT" => "PROP",
            "ENLARGE_PROP" => "NEWPRODUCT",
            "FILTER_NAME" => "arrFilter",
            "HIDE_NOT_AVAILABLE" => "N",
            "HIDE_NOT_AVAILABLE_OFFERS" => "N",
            "IBLOCK_ID" => IBLOCK_CATALOG_CATALOG,
            "IBLOCK_TYPE" => "catalog",
            "INCLUDE_SUBSECTIONS" => "Y",
            "LABEL_PROP" => array("NEWPRODUCT"),
            "LABEL_PROP_MOBILE" => array(),
            "LABEL_PROP_POSITION" => "top-left",
            "LAZY_LOAD" => "N",
            "LINE_ELEMENT_COUNT" => $elemsInRow,
            "LOAD_ON_SCROLL" => "N",
            "MESSAGE_404" => "",
            "MESS_BTN_ADD_TO_BASKET" => "В корзину",
            "MESS_BTN_BUY" => "Купить",
            "MESS_BTN_DETAIL" => "Подробнее",
            "MESS_BTN_LAZY_LOAD" => "Показать ещё",
            "MESS_BTN_SUBSCRIBE" => "Подписаться",
            "MESS_NOT_AVAILABLE" => "Нет в наличии",
            "META_DESCRIPTION" => "-",
            "META_KEYWORDS" => "-",
            "OFFERS_CART_PROPERTIES" => array(),
            "OFFERS_FIELD_CODE" => array(
                0 => "NAME",
                1 => "PREVIEW_PICTURE",
                2 => "CODE",
            ),
            "OFFERS_LIMIT" => "0",
            "OFFERS_PROPERTY_CODE" => array("TSVET", "RAZMER", "CML2_ARTICLE", "STATUS", "PRICE_FROM"),
            "OFFERS_SORT_FIELD" => "PROPERTY_CML2_ARTICLE",
            "OFFERS_SORT_FIELD2" => "sort",
            "OFFERS_SORT_ORDER" => "asc",
            "OFFERS_SORT_ORDER2" => "asc",
            "OFFER_ADD_PICT_PROP" => "MORE_PHOTO",
            "OFFER_TREE_PROPS" => array(),
            "PAGER_BASE_LINK_ENABLE" => "N",
            "PAGER_DESC_NUMBERING" => "N",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            "PAGER_SHOW_ALL" => "N",
            "PAGER_SHOW_ALWAYS" => "Y",
            "PAGER_TEMPLATE" => $pagerTmp,
            "PAGER_TITLE" => "Товары",
            "PAGE_ELEMENT_COUNT" => $pageElemCount,
            "PARTIAL_PRODUCT_PROPERTIES" => "N",
            "PRICE_CODE" => array(PRICE_CODE),
            "PRICE_VAT_INCLUDE" => "Y",
            "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
            "PRODUCT_DISPLAY_MODE" => "Y",
            "PRODUCT_ID_VARIABLE" => "id",
            "PRODUCT_PROPERTIES" => array(),
            "PRODUCT_PROPS_VARIABLE" => "prop",
            "PRODUCT_QUANTITY_VARIABLE" => "",
            "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':true}]",
            "PRODUCT_SUBSCRIPTION" => "Y",
            "PROPERTY_CODE" => array("TSVET", "RAZMER", "CML2_ARTICLE", "STATUS"),
            "PROPERTY_CODE_MOBILE" => array(),
            "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
            "RCM_TYPE" => "personal",
            "SECTION_CODE" => "",
            "SECTION_ID" => "",
            "SECTION_ID_VARIABLE" => "SECTION_ID",
            "SECTION_URL" => "",
            "SECTION_USER_FIELDS" => array("",""),
            "SEF_MODE" => "N",
            "SET_BROWSER_TITLE" => "N",
            "SET_LAST_MODIFIED" => "N",
            "SET_META_DESCRIPTION" => "Y",
            "SET_META_KEYWORDS" => "Y",
            "SET_STATUS_404" => "N",
            "SET_TITLE" => "N",
            "SHOW_404" => "N",
            "SHOW_ALL_WO_SECTION" => "Y",
            "SHOW_CLOSE_POPUP" => "N",
            "SHOW_DISCOUNT_PERCENT" => "Y",
            "SHOW_FROM_SECTION" => "N",
            "SHOW_MAX_QUANTITY" => "N",
            "SHOW_OLD_PRICE" => "N",
            "SHOW_PRICE_COUNT" => "1",
            "SHOW_SLIDER" => "Y",
            "SLIDER_INTERVAL" => "3000",
            "SLIDER_PROGRESS" => "N",
            "TEMPLATE_THEME" => "blue",
            "USE_ENHANCED_ECOMMERCE" => "Y",
            "USE_MAIN_ELEMENT_SECTION" => "N",
            "USE_PRICE_COUNT" => "N",
            "USE_PRODUCT_QUANTITY" => "N",
            "IMAGE_SIZE" => $arImageSize,
            "DEVICE_TYPE" => DEVICE_TYPE,
            "DISPLAY_COMPARE" => "N",
            "FAVORITE_ITEM" => "Y"
        )
    );
    //end
} else {
    $APPLICATION->IncludeComponent(
        "kDevelop:blank",
        "empty",
        [
            "MSG_CODE" => "KDB_EMPTY_FAVORITE"
        ]
    );
}

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
