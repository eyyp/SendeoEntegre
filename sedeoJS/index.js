const api = async ( method , params , path , token ) => {

    let options = {
        method: method,
        headers: {
            Accept: 'application/json',
            'Content-Type':'application/json;charset=utf-8',
            ...(token && { token: token }),
        },
        ...(params && {body: JSON.stringify(params)})
    }

    return await fetch(Contant.baseURL + path ,options)
    .then(response => response.json())
    .then((data) => data)
    .catch(err => {err});
}


const user = {
    token:'',
    userName: ''
}

const Contant = {
    baseURL : 'https://api.sendeo.com.tr/',  // Tüm isteklerde kullanılacak olan ana url
    LOGIN : 'api/Token/LoginAES',
    SETDELIVERY: 'api/Cargo/SETDELIVERY', //Teslimat oluşturmak için
    SETDELIVERYJOB : 'api/Cargo/SETDELIVERYJOB/',
    ATNLISTCANCARGOCOLLECT :'api/Atn/AtnListCanCargoCollect',
    CARGOMEASUREMENTUPDATE : 'api/Cargo/CARGOMEASUREMENTUPDATE'
}


const PARAMS = {
    SETDELIVERY:{
        "deliveryType": 0, //Zorunlu
        /*  6 tipi vardır 1-6 değerler alır. 
            Her bir tip belirli bir görevi temsil eder. 
            1. tipi kendi lokasyonumdan müşteriye oluşturmak için. 
            2.tipi müşterinin lokasyonundan kendi lokasyonuma oluşturmak içi örneğin iade işlemleri için.
            3.tipi tedarikçiden vb. direkt olarak müşteri için olanlarda kullanılır.
            4.tipi yeniden gönderi talimatları için kulanılır.
            5.tipi sendeo teslimat noktasına teslim edilicek ürünler için kullanılır.
            6.tipi sendeo iade noktasından alınacak gönderiler için kullanılır.
            verilen City ve District bilgileri ile il ilçe belirtiniz.
            teslimat ve iade noktaları için ise ıd belirterek hedefleme yapılabilir. 
        */   
        "referenceNo": "string",  // Zorunlu değil-Müşterilerin iç işleyişinde kullandığı referans numarasını içerir. Bu değer ile gönderiler takip edebilir, iade talepleri oluşturulabilir. 
        "description": "string",  // Zorunlu değil-Gönderiye ait özel bir bilgi veya çıklama girmek.
        "sender": "string",
        "senderBranchCode": 0,
        "senderId": "string",
        "senderAuthority": "string",
        "senderAddress": "string",
        "senderCityId": 0,
        "senderDistrictId": 0,
        "senderPhone": "string",
        "senderGSM": "string",
        "senderEmail": "string",
        "receiver": "string",
        "receiverBranchCode": 0,
        "receiverId": "string",
        "receiverAuthority": "string",
        "receiverAddress": "string",
        "receiverCityId": 0,
        "receiverDistrictId": 0,
        "receiverPhone": "string",
        "receiverGSM": "string",
        "receiverEmail": "string",
        "paymentType": 0,
        "collectionType": 0,
        "collectionPrice": 0,
        "dispatchNoteNumber": "string",
        "additionalZpl": "string",
        "serviceType": 0,
        "barcodeLabelType": 0,
        "products": [
            {
            "count": 0,
            "productCode": "string",
            "description": "string",
            "deci": 0,
            "weigth": 0,
            "deciWeight": 0
            }
        ],
        "payType": 1,
        "customerReferenceType": "string",
        "isReturn": true,
        "senderTaxpayerId": "string",
        "receiverTaxpayerId": "string",
        "integratorCustomerCode": "string"
    },
    SETDELIVERYJOB:{
        "deliveryType": 0,
        "referenceNo": "string",
        "description": "string",
        "sender": "string",
        "senderBranchCode": 0,
        "senderId": "string",
        "senderAuthority": "string",
        "senderAddress": "string",
        "senderCityId": 0,
        "senderDistrictId": 0,
        "senderPhone": "string",
        "senderGSM": "string",
        "senderEmail": "string",
        "receiver": "string",
        "receiverBranchCode": 0,
        "receiverId": "string",
        "receiverAuthority": "string",
        "receiverAddress": "string",
        "receiverCityId": 0,
        "receiverDistrictId": 0,
        "receiverPhone": "string",
        "receiverGSM": "string",
        "receiverEmail": "string",
        "paymentType": 0,
        "collectionType": 0,
        "collectionPrice": 0,
        "dispatchNoteNumber": "string",
        "additionalZpl": "string",
        "serviceType": 0,
        "barcodeLabelType": 0,
        "products": [
          {
            "count": 0,
            "productCode": "string",
            "description": "string",
            "deci": 0,
            "weigth": 0,
            "deciWeight": 0
          }
        ],
        "payType": 1,
        "customerReferenceType": "string",
        "isReturn": true,
        "senderTaxpayerId": "string",
        "receiverTaxpayerId": "string",
        "integratorCustomerCode": "string"
    },

    ATNLISTCANCARGOCOLLECT: {
        "cityId": 0,
        "districtId": 0,
        "isCollectType": 0
    }

}

const login = (username, password) => {
    let params = {
        "musteri":username,
        "sifre": password
    }
    return api (
        'POST',
        params,
        Contant.LOGIN,
        null
    )
} 

const reject = login("TEST","TesT.43e54");

console.log(reject);

const atnListCanCargoCollect = (params) => {
    return api(
        'POST',
        params,
        Contant.ATNLISTCANCARGOCOLLECT,
        token
    )
}


const setdelivery = (params) => {
    return api(
        'POST',
        params,
        Contant.SETDELIVERY,
        user.token
    )
}

const setdeliveryjob = (params,id ,token) => {
    return api (
        'POST',
        params,
        Contant.SETDELIVERYJOB + id,
        token
    )
}

//console.log(api('https://jsonplaceholder.typicode.com/users'))