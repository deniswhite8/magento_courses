<?php
/**
 * Oggetto shipping extension for Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade
 * the Oggetto Sales module to newer versions in the future.
 * If you wish to customize the Oggetto Sales module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Oggetto
 * @package   Oggetto_Shipping
 * @copyright Copyright (C) 2014, Oggetto Web (http://oggettoweb.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

$installer = $this;
$installer->startSetup();

try {
    $regions = array(
        'RU-AD'  => 'Republic of Adygea',
        'RU-AL'  => 'Altai Republic',
        'RU-BA'  => 'Republic of Bashkortostan',
        'RU-BU'  => 'Republic of Buryatia',
        'RU-DA'  => 'The Republic of Dagestan',
        'RU-IN'  => 'Republic of Ingushetia',
        'RU-KB'  => 'Kabardino-Balkaria',
        'RU-KL'  => 'Republic of Kalmykia',
        'RU-KC'  => 'Karachay-Cherkessia',
        'RU-KR'  => 'Republic of Karelia',
        'RU-KO'  => 'Komi Republic',
        'UA-43'  => 'Republic of Crimea',
        'RU-ME'  => 'Mari El Republic',
        'RU-MO'  => 'Republic of Mordovia',
        'RU-SA'  => 'The Republic of Sakha (Yakutia)',
        'RU-SE'  => 'Republic of North Ossetia - Alania',
        'RU-TA'  => 'The Republic of Tatarstan',
        'RU-TY'  => 'Republic of Tyva',
        'RU-UD'  => 'Udmurt Republic',
        'RU-KK'  => 'Republic of Khakassia',
        'RU-CE'  => 'The Chechen Republic',
        'RU-CU'  => 'Chuvash Republic',
        'RU-ALT' => 'Altay region',
        'RU-ZAB' => 'Trans-Baikal Territory',
        'RU-KAM' => 'Kamchatka Krai',
        'RU-KDA' => 'Krasnodar region',
        'RU-KYA' => 'Krasnoyarsk Territory',
        'RU-PER' => 'Perm Krai',
        'RU-PRI' => 'Primorsky Krai',
        'RU-STA' => 'Stavropol region',
        'RU-KHA' => 'Khabarovsk Krai',
        'RU-AMU' => 'Amur Oblast',
        'RU-ARK' => 'Arkhangelsk region',
        'RU-AST' => 'Astrakhan region',
        'RU-BEL' => 'Belgorod region',
        'RU-BRY' => 'Bryansk region',
        'RU-VLA' => 'Vladimir region',
        'RU-VGG' => 'Volgograd region',
        'RU-VLG' => 'Vologda region',
        'RU-VOR' => 'Voronezh region',
        'RU-IVA' => 'Ivanovo region',
        'RU-IRK' => 'Irkutsk region',
        'RU-KGD' => 'Kaliningrad region',
        'RU-KLU' => 'Kaluga region',
        'RU-KEM' => 'Kemerovo region',
        'RU-KIR' => 'Kirov region',
        'RU-KOS' => 'Kostroma region',
        'RU-KGN' => 'Kurgan region',
        'RU-KRS' => 'Kursk region',
        'RU-LEN' => 'Leningrad region',
        'RU-LIP' => 'Lipetsk region',
        'RU-MAG' => 'Magadan region',
        'RU-MOS' => 'Moscow region',
        'RU-MUR' => 'Murmansk region',
        'RU-NIZ' => 'Nizhny Novgorod region',
        'RU-NGR' => 'Novgorod region',
        'RU-NVS' => 'Novosibirsk region',
        'RU-OMS' => 'Omsk region',
        'RU-ORE' => 'Orenburg region',
        'RU-ORL' => 'Orel region',
        'RU-PNZ' => 'Penza region',
        'RU-PSK' => 'Pskov region',
        'RU-ROS' => 'Rostov region',
        'RU-RYA' => 'Ryazan region',
        'RU-SAM' => 'Samara region',
        'RU-SAR' => 'Saratov region',
        'RU-SAK' => 'Sakhalin Region',
        'RU-SVE' => 'Sverdlovsk region',
        'RU-SMO' => 'Smolensk region',
        'RU-TAM' => 'Tambov region',
        'RU-TVE' => 'Tver region',
        'RU-TOM' => 'Tomsk Oblast',
        'RU-TUL' => 'Tula region',
        'RU-TYU' => 'Tyumen region',
        'RU-ULY' => 'Ulyanovsk region',
        'RU-CHE' => 'Chelyabinsk region',
        'RU-YAR' => 'Yaroslavl region',
        'RU-MOW' => 'Moscow',
        'RU-SPE' => 'St. Petersburg',
        'UA-40'  => 'Sevastopol',
        'RU-YEV' => 'Jewish Autonomous Region',
        'RU-NEN' => 'Nenets Autonomous Okrug',
        'RU-KHM' => 'Khanty-Mansi Autonomous Okrug - Yugra',
        'RU-CHU' => 'Chukotka Autonomous Okrug',
        'RU-YAN' => 'Yamal-Nenets Autonomous Okrug'
    );


    $regionTranslations = [
        'RU-AD'  => [
            'en_US' => 'Republic of Adygea',
            'ru_RU' => 'Республика Адыгея'
        ],
        'RU-AL'  => [
            'en_US' => 'Altai Republic',
            'ru_RU' => 'Республика Алтай'
        ],
        'RU-BA'  => [
            'en_US' => 'Republic of Bashkortostan',
            'ru_RU' => 'Республика Башкортостан'
        ],
        'RU-BU'  => [
            'en_US' => 'Republic of Buryatia',
            'ru_RU' => 'Республика Бурятия'
        ],
        'RU-DA'  => [
            'en_US' => 'The Republic of Dagestan',
            'ru_RU' => 'Республика Дагестан'
        ],
        'RU-IN'  => [
            'en_US' => 'Republic of Ingushetia',
            'ru_RU' => 'Республика Ингушетия'
        ],
        'RU-KB'  => [
            'en_US' => 'Kabardino-Balkaria',
            'ru_RU' => 'Кабардино-Балкарская республика'
        ],
        'RU-KL'  => [
            'en_US' => 'Republic of Kalmykia',
            'ru_RU' => 'Республика Калмыкия'
        ],
        'RU-KC'  => [
            'en_US' => 'Karachay-Cherkessia',
            'ru_RU' => 'Карачаево-Черкесская республика'
        ],
        'RU-KR'  => [
            'en_US' => 'Republic of Karelia',
            'ru_RU' => 'Республика Карелия'
        ],
        'RU-KO'  => [
            'en_US' => 'Komi Republic',
            'ru_RU' => 'Республика Коми'
        ],
        'UA-43'  => [
            'en_US' => 'Republic of Crimea',
            'ru_RU' => 'Республика Крым'
        ],
        'RU-ME'  => [
            'en_US' => 'Mari El Republic',
            'ru_RU' => 'Республика Марий Эл'
        ],
        'RU-MO'  => [
            'en_US' => 'Republic of Mordovia',
            'ru_RU' => 'Республика Мордовия'
        ],
        'RU-SA'  => [
            'en_US' => 'The Republic of Sakha (Yakutia)',
            'ru_RU' => 'Республика Саха (Якутия)'
        ],
        'RU-SE'  => [
            'en_US' => 'Republic of North Ossetia - Alania',
            'ru_RU' => 'Республика Северная Осетия — Алания'
        ],
        'RU-TA'  => [
            'en_US' => 'The Republic of Tatarstan',
            'ru_RU' => 'Республика Татарстан'
        ],
        'RU-TY'  => [
            'en_US' => 'Republic of Tyva',
            'ru_RU' => 'Республика Тыва'
        ],
        'RU-UD'  => [
            'en_US' => 'Udmurt Republic',
            'ru_RU' => 'Удмуртская республика'
        ],
        'RU-KK'  => [
            'en_US' => 'Republic of Khakassia',
            'ru_RU' => 'Республика Хакасия'
        ],
        'RU-CE'  => [
            'en_US' => 'The Chechen Republic',
            'ru_RU' => 'Чеченская республика'
        ],
        'RU-CU'  => [
            'en_US' => 'Chuvash Republic',
            'ru_RU' => 'Чувашская республика'
        ],
        'RU-ALT' => [
            'en_US' => 'Altay region',
            'ru_RU' => 'Алтайский край'
        ],
        'RU-ZAB' => [
            'en_US' => 'Trans-Baikal Territory',
            'ru_RU' => 'Забайкальский край'
        ],
        'RU-KAM' => [
            'en_US' => 'Kamchatka Krai',
            'ru_RU' => 'Камчатский край'
        ],
        'RU-KDA' => [
            'en_US' => 'Krasnodar region',
            'ru_RU' => 'Краснодарский край'
        ],
        'RU-KYA' => [
            'en_US' => 'Krasnoyarsk Territory',
            'ru_RU' => 'Красноярский край'
        ],
        'RU-PER' => [
            'en_US' => 'Perm Krai',
            'ru_RU' => 'Пермский край'
        ],
        'RU-PRI' => [
            'en_US' => 'Primorsky Krai',
            'ru_RU' => 'Приморский край'
        ],
        'RU-STA' => [
            'en_US' => 'Stavropol region',
            'ru_RU' => 'Ставропольский край'
        ],
        'RU-KHA' => [
            'en_US' => 'Khabarovsk Krai',
            'ru_RU' => 'Хабаровский край'
        ],
        'RU-AMU' => [
            'en_US' => 'Amur Oblast',
            'ru_RU' => 'Амурская область'
        ],
        'RU-ARK' => [
            'en_US' => 'Arkhangelsk region',
            'ru_RU' => 'Архангельская область'
        ],
        'RU-AST' => [
            'en_US' => 'Astrakhan region',
            'ru_RU' => 'Астраханская область'
        ],
        'RU-BEL' => [
            'en_US' => 'Belgorod region',
            'ru_RU' => 'Белгородская область'
        ],
        'RU-BRY' => [
            'en_US' => 'Bryansk region',
            'ru_RU' => 'Брянская область'
        ],
        'RU-VLA' => [
            'en_US' => 'Vladimir region',
            'ru_RU' => 'Владимирская область'
        ],
        'RU-VGG' => [
            'en_US' => 'Volgograd region',
            'ru_RU' => 'Волгоградская область'
        ],
        'RU-VLG' => [
            'en_US' => 'Vologda region',
            'ru_RU' => 'Вологодская область'
        ],
        'RU-VOR' => [
            'en_US' => 'Voronezh region',
            'ru_RU' => 'Воронежская область'
        ],
        'RU-IVA' => [
            'en_US' => 'Ivanovo region',
            'ru_RU' => 'Ивановская область'
        ],
        'RU-IRK' => [
            'en_US' => 'Irkutsk region',
            'ru_RU' => 'Иркутская область'
        ],
        'RU-KGD' => [
            'en_US' => 'Kaliningrad region',
            'ru_RU' => 'Калининградская область'
        ],
        'RU-KLU' => [
            'en_US' => 'Kaluga region',
            'ru_RU' => 'Калужская область'
        ],
        'RU-KEM' => [
            'en_US' => 'Kemerovo region',
            'ru_RU' => 'Кемеровская область'
        ],
        'RU-KIR' => [
            'en_US' => 'Kirov region',
            'ru_RU' => 'Кировская область'
        ],
        'RU-KOS' => [
            'en_US' => 'Kostroma region',
            'ru_RU' => 'Костромская область'
        ],
        'RU-KGN' => [
            'en_US' => 'Kurgan region',
            'ru_RU' => 'Курганская область'
        ],
        'RU-KRS' => [
            'en_US' => 'Kursk region',
            'ru_RU' => 'Курская область'
        ],
        'RU-LEN' => [
            'en_US' => 'Leningrad region',
            'ru_RU' => 'Ленинградская область'
        ],
        'RU-LIP' => [
            'en_US' => 'Lipetsk region',
            'ru_RU' => 'Липецкая область'
        ],
        'RU-MAG' => [
            'en_US' => 'Magadan region',
            'ru_RU' => 'Магаданская область'
        ],
        'RU-MOS' => [
            'en_US' => 'Moscow region',
            'ru_RU' => 'Московская область'
        ],
        'RU-MUR' => [
            'en_US' => 'Murmansk region',
            'ru_RU' => 'Мурманская область'
        ],
        'RU-NIZ' => [
            'en_US' => 'Nizhny Novgorod region',
            'ru_RU' => 'Нижегородская область'
        ],
        'RU-NGR' => [
            'en_US' => 'Novgorod region',
            'ru_RU' => 'Новгородская область'
        ],
        'RU-NVS' => [
            'en_US' => 'Novosibirsk region',
            'ru_RU' => 'Новосибирская область'
        ],
        'RU-OMS' => [
            'en_US' => 'Omsk region',
            'ru_RU' => 'Омская область'
        ],
        'RU-ORE' => [
            'en_US' => 'Orenburg region',
            'ru_RU' => 'Оренбургская область'
        ],
        'RU-ORL' => [
            'en_US' => 'Orel region',
            'ru_RU' => 'Орловская область'
        ],
        'RU-PNZ' => [
            'en_US' => 'Penza region',
            'ru_RU' => 'Пензенская область'
        ],
        'RU-PSK' => [
            'en_US' => 'Pskov region',
            'ru_RU' => 'Псковская область'
        ],
        'RU-ROS' => [
            'en_US' => 'Rostov region',
            'ru_RU' => 'Ростовская область'
        ],
        'RU-RYA' => [
            'en_US' => 'Ryazan region',
            'ru_RU' => 'Рязанская область'
        ],
        'RU-SAM' => [
            'en_US' => 'Samara region',
            'ru_RU' => 'Самарская область'
        ],
        'RU-SAR' => [
            'en_US' => 'Saratov region',
            'ru_RU' => 'Саратовская область'
        ],
        'RU-SAK' => [
            'en_US' => 'Sakhalin Region',
            'ru_RU' => 'Сахалинская область'
        ],
        'RU-SVE' => [
            'en_US' => 'Sverdlovsk region',
            'ru_RU' => 'Свердловская область'
        ],
        'RU-SMO' => [
            'en_US' => 'Smolensk region',
            'ru_RU' => 'Смоленская область'
        ],
        'RU-TAM' => [
            'en_US' => 'Tambov region',
            'ru_RU' => 'Тамбовская область'
        ],
        'RU-TVE' => [
            'en_US' => 'Tver region',
            'ru_RU' => 'Тверская область'
        ],
        'RU-TOM' => [
            'en_US' => 'Tomsk Oblast',
            'ru_RU' => 'Томская область'
        ],
        'RU-TUL' => [
            'en_US' => 'Tula region',
            'ru_RU' => 'Тульская область'
        ],
        'RU-TYU' => [
            'en_US' => 'Tyumen region',
            'ru_RU' => 'Тюменская область'
        ],
        'RU-ULY' => [
            'en_US' => 'Ulyanovsk region',
            'ru_RU' => 'Ульяновская область'
        ],
        'RU-CHE' => [
            'en_US' => 'Chelyabinsk region',
            'ru_RU' => 'Челябинская область'
        ],
        'RU-YAR' => [
            'en_US' => 'Yaroslavl region',
            'ru_RU' => 'Ярославская область'
        ],
        'RU-MOW' => [
            'en_US' => 'Moscow',
            'ru_RU' => 'Москва'
        ],
        'RU-SPE' => [
            'en_US' => 'St. Petersburg',
            'ru_RU' => 'Санкт-Петербург'
        ],
        'UA-40'  => [
            'en_US' => 'Sevastopol',
            'ru_RU' => 'Севастополь'
        ],
        'RU-YEV' => [
            'en_US' => 'Jewish Autonomous Region',
            'ru_RU' => 'Еврейская автономная область'
        ],
        'RU-NEN' => [
            'en_US' => 'Nenets Autonomous Okrug',
            'ru_RU' => 'Ненецкий автономный округ'
        ],
        'RU-KHM' => [
            'en_US' => 'Khanty-Mansi Autonomous Okrug - Yugra',
            'ru_RU' => 'Ханты-Мансийский автономный округ - Югра'
        ],
        'RU-CHU' => [
            'en_US' => 'Chukotka Autonomous Okrug',
            'ru_RU' => 'Чукотский автономный округ'
        ],
        'RU-YAN' => [
            'en_US' => 'Yamal-Nenets Autonomous Okrug',
            'ru_RU' => 'Ямало-Ненецкий автономный окру'
        ],
    ];

    foreach ($regions as $code => $name) {
        Mage::getModel('directory/region')->setData(
            array(
                'country_id' => 'RU',
                'code' => $code,
                'default_name' => $name
            )
        )->save();
    }

    $regionCollection = Mage::getResourceModel('directory/region_collection')->addCountryFilter('RU')->load()->getItems();
    $query = "INSERT INTO {$this->getTable('directory/country_region_name')} (locale, region_id, name) VALUES ";

    foreach ($regionCollection as $region) {
        $code = $region->getCode();
        $id = $region->getId();
        $translations = $regionTranslations[$code];
        foreach ($translations as $locale => $name) {
            $query .= "('{$locale}', {$id}, '{$name}'), ";
        }
    }

    $query = rtrim($query, ', ') . ';';
    $installer->run($query);

} catch (Exception $e) {
    Mage::logException($e);
}

$installer->endSetup();