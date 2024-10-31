# Proje Kurulumu 
1. composer install
2. cp .env.example .env
3. ./vendor/bin/sail up -d
4. ./vendor/bin/sail migrate
5. ./vendor/bin/sail db:seed

# Uygulama arayüzü
http://localhost üzerinden uygulama arayüzüne erişebilirsiniz.

# API Endpointleri
1. /api/v1/banks
   1. GET,POST,PUT,DELETE işlemleri Restfull olarak kullanılabilir
2. /api/v1/interest-rates
   1. GET,POST,PUT,DELETE işlemleri Restfull olarak kullanılabilir

# Log table
Mysql üzerinde logları yazdırdım. AppServiceProvider üzerinde mysql'e yazdırma işlemini yapılandırdım

# Uygulama Yapısı
1. Her restful endpoitini için bir servis sınıfı mevcut
2. Her model için bir repository mevcut
   1. Repositoryler için cache-aside kullandım
   2. Observer içerisinde gerçekleşen durumlar için cache clear yapıldı
   3. InterestRateObserver içerisinde daily_rate girilen rate ve term_days e göre hesaplanarak ezildi
3. Restful controller oluşturuldu
4. Interface DI tanımlandı
5. cache-key için helpers.php oluşturuldu
6. Kullanıcı arayüzü için blade oluşturuldu
7. Cache içi redis kullanıldı
8. Request ve Resource kullanıldı
9. Request ve Response loglandı
10. Loglar Mysql e alındı
11. Exception durumları json olarak dönüyor.

# Diger Çözümler
1. Repository katmanında cache-aside kullandım fakat proxy pattern kullanılarak cache mekanizması işletilebilirdi.
2. Authentication-Authorization kullanmadım, istenmedi. 

# Uygulama Akışı
1. http://localhost adresi üzerinde Vade ve Para birimi bilgileri veritabanından okunur
2. http://localhost adresine giren kullanıca Anapara, Vade ve Para birimi seçer
3. Vade ve Para birimine uygun bankaların faiz oranları çekilir
   1. Eğer özel bir gün girmiş ise; en yakın vade günü ve uygun para birimine göre  faiz oranları çekilir
4. Faiz hesaplamaları gerçekleştirilir.
5. Kullanıcıya response (Resource) dönülür
6. Burada Her isteği karşılayan bir controller bulunmaktadır. Controllerlar ilgili Service sınıfını DI ile kullanılır
7. Her Service bir Repository sınıfı DI ile barındırır ve veritabanı işlemleri burada gerçekleşir.

Graylog kurulumunda docker ile ilgili bazı problemlere takıldığım için geri aldım.
