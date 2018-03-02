<?php
namespace pastuhov\ymlcatalog;

use yii\db\ActiveRecordInterface;

/**
 * Простое товарное предложение.
 *
 * @link https://yandex.st/market-export/1.0-17/partner/help/YML.xml
 * @package pastuhov\yml
 */
interface OfferInterface
{
    /**
     * Ставка на клик для карточек.
     *
     * Действует только на карточках моделей.
     *
     * @link http://help.yandex.ru/partnermarket/about/placement-positions.xml#mesto2
     * @return integer|null
     */
    public function getCbid();

    /**
     * Основная ставка.
     *
     * Действует на всех местах размещения с возможностью управления ценой клика, если не указана ставка для отдельного места.
     *
     * @link http://help.yandex.ru/partnermarket/auction/placement.xml#placement
     * @return integer|null
     */
    public function getBid();

    /**
     * Размер комиссии на товарное предложение, участвующее в программе «Заказ на Маркете».
     *
     * Значение должно быть целым положительным числом, где две последние цифры — это сотая и десятая часть процентов. Таким образом, значение 100 соответствует комиссии в 1%. Примеры:
     * Значение 220 соответствует комиссии 2,2% от стоимости товара.
     * Значение 1220 соответствует комиссии 12,2%.
     * Значение 22 соответствует комиссии 0,22%.
     * Если для элемента указано некорректное значение либо значение меньше минимальной комиссии, списывается минимальный размер комиссии.
     *
     * @return integer|null
     */
    public function getFee();

    /**
     * URL страницы товара.
     *
     * Максимальная длина URL — 512 символов.
     * Необязательный элемент для магазинов-салонов.
     *
     * @return string|null
     */
    public function getUrl();

    /**
     * Цена.
     *
     * Цена, по которой данный товар можно приобрести. Цена товарного предложения округляется, формат, в котором
     * она отображается, зависит от настроек пользователя.
     * Обязательный элемент.
     *
     * @return string
     */
    public function getPrice();

    /**
     * Старая цена.
     *
     * Старая цена на товар, которая обязательно должна быть выше новой цены (<price>). Параметр <oldprice> необходим
     * для автоматического расчета скидки на товар.
     * Необязательный элемент.
     *
     * @return string|null
     */
    public function getOldprice();

    /**
     * Идентификатор валюты.
     *
     * Идентификатор валюты товара (RUR, USD, UAH, KZT). Для корректного отображения цены в национальной валюте
     * необходимо использовать идентификатор (например, UAH) с соответствующим значением цены.
     * Обязательный элемент.
     *
     * @return string
     */
    public function getCurrencyId();

    /**
     * Идентификатор категории.
     *
     * Идентификатор категории товара, присвоенный магазином (целое число не более 18 знаков). Товарное предложение
     * может принадлежать только одной категории.
     * Обязательный элемент. Элемент <offer> может содержать только один элемент <categoryId>.
     *
     * @return string
     */
    public function getCategoryId();

    /**
     * Ссылки на картинку.
     *
     * Ссылка на картинку соответствующего товарного предложения. Недопустимо давать ссылку на «заглушку»,
     * т. е. на страницу, где написано «картинка отсутствует», или на логотип магазина.
     * Максимальная длина URL — 512 символов.
     * Необязательный элемент.
     *
     * Для каждого товарного предложения в элементе <offer> можно указать до десяти URL-адресов изображений,
     * соответствующих данному товарному предложению.
     *
     * @return array
     */
    public function getPictures();

    /**
     * Возможность доставки соответствующего товара.
     *
     * Возможные значения:
     *    - false — товар не может быть доставлен;
     *    - true — товар доставляется на условиях, которые описываются в партнерском интерфейсе на странице
     *      Параметры размещения.
     * Необязательный элемент.
     * @link http://help.yandex.ru/partnermarket/settings/placement.xml#placement
     *
     * @return string|null
     */
    public function getDelivery();

    /**
     * Опции доставки товарного предложения
     *
     * @return array
     */
    public function getDeliveryOptions();

    /**
     * Возможность зарезервировать выбранный товар и забрать его самостоятельно.
     *
     * Возможные значения:
     *    1) false — возможность «самовывоза» отсутствует;
     *    2) true — товар можно забрать самостоятельно.
     * Необязательный элемент.
     *
     * @return string|null
     */
    public function getPickup();

    /**
     * Статус доступности товара.
     *
     * "false" — товарное предложение на заказ. Магазин готов принять заказ и осуществить поставку товара в течение
     *  согласованного с покупателем срока, не превышающего двух месяцев (за исключением товаров, изготавливаемых на заказ,
     *  ориентировочный срок поставки которых оговаривается с покупателем во время заказа).
     * "true" — товарное предложение в наличии. Магазин готов доставить либо отправить товар покупателю в течение двух
     *  рабочих дней.
     *
     * @return string
     */
    public function getAvailable();

    /**
     * Возможность купить соответствующий товар в розничном магазине.
     *
     * Возможные значения:
     *    1) false — возможность покупки в розничном магазине отсутствует;
     *    2) true — товар можно купить в розничном магазине.
     * Необязательный элемент.
     *
     * @return string|null
     */
    public function getStore();

    /**
     *
     * В элементе указывается:
     * количество товара в точке продаж (пункте выдачи или розничном магазине);
     * доступность товара для бронирования.
     *
     *
     * Атрибут id (обязательный) — идентификатор точки продаж, заданный в личном кабинете. С помощью идентификатора к
     * конкретной точке продаж привязывается информация по товарам и бронированию.
     * Атрибут instock (необязательный) — количество товара, доступное для бронирования в точке продаж. Число должно
     * быть равно либо больше 0. Если атрибут не указан, действует значение по умолчанию — 0.
     * Атрибут booking (необязательный) — возможность бронирования в точке продаж. Возможные значения: true (можно
     * забронировать), false (нельзя забронировать). Если атрибут не указан, действует значение по умолчанию — true.
     *
     * @return array
     */
    public function getOutlets();

    /**
     * Описание товарного предложения.
     *
     * Длина текста не более 3000 символов (не включая знаки препинания), запрещено использовать HTML-теги
     * (информация внутри тегов публиковаться не будет).
     * Если длина описания выходит за пределы допустимого значения,
     * то при публикации текст обрезается и в конце ставится многоточие.
     * Необязательный элемент.
     *
     * @return string|null
     */
    public function getDescription();

    /**
     * Элемент используется для отражения информации о:
     *    - минимальной сумме заказа, минимальной партии товара, необходимости предоплаты
     *     (указание элемента обязательно);
     *    - вариантах оплаты, описания акций и распродаж (указание элемента необязательно).
     * Допустимая длина текста в элементе — 50 символов.
     * Необязательный элемент.
     *
     * @return string
     */
    public function getSales_notes();

    /**
     * Минимальное количество одинаковых товаров в одном заказе (для случаев, когда покупка возможна только комплектом,
     * а не поштучно). Элемент используется только в категориях «Автошины», «Грузовые шины», «Мотошины», «Диски».
     *
     * @return string
     */
    public function getMinQuantity();

    /**
     * Количество товара, которое покупатель может добавлять к минимальному в корзине Яндекс.Маркета. Элемент
     * используется в дополнение к min-quantity и только в категориях «Автошины», «Грузовые шины», «Мотошины», «Диски».
     *
     * @return string
     */
    public function getStepQuantity();

    /**
     * Элемент предназначен для отметки товаров, имеющих официальную гарантию производителя.
     *    Необязательный элемент.
     *    Возможные значения:
     *    - "false" — товар не имеет официальной гарантии;
     *    - "true" — товар имеет официальную гарантию.
     *
     * @return string
     */
    public function getManufacturer_warranty();

    /**
     * Элемент предназначен для указания страны производства товара. Список стран, которые могут быть указаны в этом
     * элементе, доступен по адресу: http://partner.market.yandex.ru/pages/help/Countries.pdf.
     * Примечание. Если вы хотите участвовать в программе «Заказ на Маркете», то желательно указывать данный
     * элемент в YML-файле.
     * Необязательный элемент.
     *
     * @return string|null
     */
    public function getCountry_of_origin();

    /**
     * Элемент обязателен для обозначения товара, имеющего отношение к удовлетворению сексуальных потребностей,
     * либо иным образом эксплуатирующего интерес к сексу.
     * Необязательный элемент.
     *
     * @return string|null
     */
    public function getAdult();

    /**
     * Возрастная категория товара.
     *
     * Годы задаются с помощью атрибута unit со значением year, месяцы — с помощью
     * атрибута unit со значением month.
     * Допустимые значения параметра при unit="year": 0, 6, 12, 16, 18. Допустимые значения параметра при
     * unit="month": 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12.
     * Необязательный элемент.
     *
     * @return string|null
     */
    public function getAge();

    /**
     * Штрихкод товара, указанный производителем.
     * Необязательный элемент. Элемент <offer> может содержать несколько элементов <barcode>.
     *
     * @return string|null
     */
    public function getBarcode();

    /**
     * Элемент предназначен для управления участием товарных предложений в программе «Заказ на Маркете».
     * Необязательный элемент.
     *
     * @return string|null
     */
    public function getCpa();

    /**
     * Элемент предназначен для указания характеристик товара.
     *
     * Для описания каждого параметра используется отдельный элемент <param>.
     * Необязательный элемент. Элемент <offer> может содержать несколько элементов <param>.
     *
     * @return array
     */
    public function getParams();

    /**
     * Элемент предназначен для указания срока годности / срока службы либо для указания даты истечения срока годности / срока службы.
     *
     * Значение элемента должно быть в формате ISO8601:
     * — для срока годности / срока службы: P1Y2M10DT2H30M. Расшифровка примера — 1 год, 2 месяца, 10 дней, 2 часа и 30 минут;
     * — для даты истечения срока годности / срока службы: YYYY-MM-DDThh:mm.(@TODO не поддерживается)
     *
     * @return string|null
     */
    public function getExpiry();

    /**
     * Элемент предназначен для указания веса товара.
     *
     * Вес указывается в килограммах с учетом упаковки.
     * Формат элемента: положительное число с точностью 0.001, разделитель целой и дробной части — точка.
     * При указании более высокой точности значение автоматически округляется следующим способом:
     * если четвертый знак после разделителя меньше 5, то третий знак сохраняется, а все последующие обнуляются;
     * если четвертый знак после разделителя больше или равен 5, то третий знак увеличивается на единицу, а все последующие обнуляются.
     *
     * @return mixed
     */
    public function getWeight();

    /**
     * Элемент предназначен для указания габаритов товара (длина, ширина, высота) в упаковке.
     *
     * Размеры указываются в сантиметрах.
     * Формат элемента: три положительных числа с точностью 0.001, разделитель целой и дробной части — точка.
     * Числа должны быть разделены символом «/» без пробелов.
     * При указании более высокой точности значение автоматически округляется следующим способом:
     * если четвертый знак после разделителя меньше 5, то третий знак сохраняется, а все последующие обнуляются;
     * если четвертый знак после разделителя больше или равен 5, то третий знак увеличивается на единицу, а все последующие обнуляются.
     *
     * @return array
     */
    public function getDimensionsValues();

    /**
     * Элемент предназначен для обозначения товара, который можно скачать.
     *
     * Если указано значение параметра true, товарное предложение показывается во всех регионах независимо от регионов
     * доставки, указанных магазином на странице
     *
     * @return string|null
     */
    public function getDownloadable();

    /**
     * Элемент используется в описаниях всех предложений, которые являются вариациями одной модели, при этом элемент
     * должен иметь одинаковое значение.
     *
     * Значение должно быть целым числом, максимум 9 разрядов.
     * Внимание. Элемент используется только в формате YML и только в категориях Одежда, обувь и аксессуары, Мебель,
     * Косметика, парфюмерия и уход, Детские товары, Аксессуары для портативной электроники.
     *
     * @return int|null
     */
    public function getGroup_id();

    /**
     * Элемент предназначен для передачи рекомендованных товаров.
     *
     * @return array|null
     */
    public function getRecValues();
}