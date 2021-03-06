<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?if ($arResult["ITEMS_COUNT"] > 0) :?>
    <hr>
    <div class="js-tabs">
        <div class="content_tab">
            <?foreach ($arResult["SECTIONS"] as $arSection) :?>
                <a href="#" class="content_tab-item" data-tab_target="#delivery_region-<?=$arSection["CODE"]?>"><?=$arSection["NAME"]?></a>
            <?endforeach?>
        </div>
        <div data-tab_content>
            <?foreach ($arResult["SECTIONS"] as $arSection) :?>
                <div id="delivery_region-<?=$arSection["CODE"]?>" data-tab_item>
                    <div flex-align="start"><?=($arSection["DESCRIPTION_TYPE"] == "text" ? $arSection["DESCRIPTION"] : htmlspecialcharsback($arSection["DESCRIPTION"]))?></div>
                    <?if (isset($arResult["JS_MAP_DATA"]["delivery_region-".$arSection["CODE"]])) :?>
                        <div id="delivery_region-<?=$arSection["CODE"]?>-map" style="height:520px"></div>
                    <?endif?>
                </div>
            <?endforeach?>
        </div>
    </div>
    <?if (count($arResult["JS_MAP_DATA"]) > 0) :?>
        <script>
            window.mapsVars = {};
            var arMapData = <?=CUtil::PhpToJsObject($arResult["JS_MAP_DATA"])?>;
            <?foreach ($arResult["JS_MAP_DATA"] as $mapId => $arMapData) :?>
                var ob_<?=$arMapData["code"]?>_map = new obMap({
                    mapCenter: [59.938732,30.316229],
                    mapZoom: 9,
                    mapId: "<?=$mapId?>-map"
                });
                ob_<?=$arMapData["code"]?>_map.setPlacemarkOptions({
                    iconLayout: "default#image",
                    iconImageHref: "./images/icons/marker_map.svg",
                    iconImageSize: [37,45],
                    iconImageOffset: [-18,-22]
                });
                window.mapsVars["<?=$mapId?>"] = "ob_<?=$arMapData["code"]?>_map";
            <?endforeach?>
            ymaps.ready(function(){
                for (var mapId in arMapData) {
                    if (!!arMapData[mapId].store) {
                        var arPlacemarkProps = [],
                            arMarkerInfo = [];
                        for (var counter in arMapData[mapId].store) {
                            arPlacemarkProps.push({balloonContent: arMapData[mapId].store[counter].TITLE});
                            arMarkerInfo.push({coords: [arMapData[mapId].store[counter].GPS_N, arMapData[mapId].store[counter].GPS_S]});
                        }
                        window[window.mapsVars[mapId]].setPlacemarkProperties(arPlacemarkProps);
                        window[window.mapsVars[mapId]].setMarkerInfo(arMarkerInfo);
                    }
                    window[window.mapsVars[mapId]].initMap();
                    if (arMapData[mapId].items.length > 0) {
                        for (var counter in arMapData[mapId].items) {
                            if (arMapData[mapId].items[counter].polygon.items.length > 0) {
                                for (var innerCounter in arMapData[mapId].items[counter].polygon.items) {
                                    arMapData[mapId].items[counter].polygon.items[innerCounter] = arMapData[mapId].items[counter].polygon.items[innerCounter].split(",");
                                }
                            }
                        }
                        window[window.mapsVars[mapId]].setPolygon(
                            arMapData[mapId].items[counter].polygon.items,
                            [],
                            {},
                            {
                                fillColor: arMapData[mapId].items[counter].polygon.color,
                                strokeWidth: 5
                            }
                        );
                    }
                }
            });
        </script>
    <?endif?>
<?endif?>