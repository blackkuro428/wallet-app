FROM dunglas/frankenphp:latest

# 必要なPHP拡張のインストールと準備
RUN install-php-extensions pdo_pgsql pgsql

COPY . /app

# Composerで依存関係をインストール
RUN composer install --no-dev --optimize-autoloader

# 権限の調整
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

ENV PORT=80
EXPOSE 80

CMD ["php", "artisan", "octane:start", "--server=frankenphp", "--host=0.0.0.0", "--port=80"]
