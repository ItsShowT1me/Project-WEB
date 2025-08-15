# ใช้ image PHP + Apache
FROM php:8.2-apache

# คัดลอกโค้ดทั้งหมดไปยัง Apache web root
COPY . /var/www/html/

# เปิดพอร์ต
EXPOSE 80

RUN apt-get update && apt-get install -y php-pgsql
