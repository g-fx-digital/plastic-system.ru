<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main,
	Bitrix\Main\Localization\Loc,
	Bitrix\Main\Page\Asset;

//Asset::getInstance()->addJs("/bitrix/components/bitrix/sale.order.payment.change/templates/.default/script.js");
//Asset::getInstance()->addCss("/bitrix/components/bitrix/sale.order.payment.change/templates/.default/style.css");
//CJSCore::Init(array('clipboard', 'fx'));

Loc::loadMessages(__FILE__);

if (!empty($arResult['ERRORS']['FATAL']))
{
	foreach($arResult['ERRORS']['FATAL'] as $error)
	{
		ShowError($error);
	}
	$component = $this->__component;
	if ($arParams['AUTH_FORM_IN_TEMPLATE'] && isset($arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED]))
	{
		$APPLICATION->AuthForm('', false, false, 'N', false);
	}

}
else
{
	?>
    <div class="title-3">Мои заказы</div>
    <?if (count($arResult['ORDERS']) > 0) :?>
        <div class="personal_order_list table">
            <div class="table-row">
                <div class="personal_order_list-head table-cell">Дата</div>
                <div class="personal_order_list-head table-cell">Номер заказа</div>
                <div class="personal_order_list-head table-cell">Количество</div>
                <div class="personal_order_list-head table-cell">Сумма</div>
                <div class="personal_order_list-head table-cell">Статус заказа</div>
            </div>
            <?
            $orderHeaderStatus = null;
            foreach ($arResult['ORDERS'] as $order) :
                if ($orderHeaderStatus !== $order['ORDER']['STATUS_ID'] && $arResult['SORT_TYPE'] == 'STATUS') {
                    $orderHeaderStatus = $order['ORDER']['STATUS_ID'];
                }
                $count = count($order['BASKET_ITEMS']) % 10;
                if ($count == '1') {
                    $measure = Loc::getMessage('SPOL_TPL_GOOD');
                }
                elseif ($count >= '2' && $count <= '4') {
                    $measure = Loc::getMessage('SPOL_TPL_TWO_GOODS');
                }
                else {
                    $measure = Loc::getMessage('SPOL_TPL_GOODS');
                }
                ?>
                <div class="table-row">
                    <div class="personal_order_list-cell table-cell"><?=$order['ORDER']['DATE_INSERT']->format($arParams['ACTIVE_DATE_FORMAT'])?></div>
                    <div class="personal_order_list-cell table-cell">
                        <a href="#" class="link dashed" data-popup-open="#order-popup"><b><?=$order['ORDER']['ACCOUNT_NUMBER']?></b></a>
                    </div>
                    <div class="personal_order_list-cell table-cell"><?=count($order['BASKET_ITEMS']);?> <?=$measure?></div>
                    <div class="personal_order_list-cell table-cell"><b><?=$order['ORDER']['FORMATED_PRICE']?></b></div>
                    <div class="personal_order_list-cell table-cell">
                        <label class="order_label" style="background-color:#D9D9D9"><?=$arResult['INFO']['STATUS'][$orderHeaderStatus]['NAME']?></label>
                    </div>
                </div>
            <?endforeach?>
        </div>
        <?=$arResult["NAV_STRING"]?>
    <?else:?>
        <p><?=Loc::getMEssage("SPOL_TPL_EMPTY_ORDER_LIST")?></p>
    <?endif?>
    <?
}