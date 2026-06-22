FROM dunglas/frankenphp:latest

# 必要なPHP拡張のインストールと準備
RUN install-php-extensions pdo_pgsql pgsql zip

#【追加】ComposerをDockerの中に持ってくる
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /app

# Composerで依存関係をインストール
RUN composer install --optimize-autoloader --no-interaction --ignore-platform-reqs

# CSSやJSを本番用にビルドしてmanifest.jsonを作る
RUN apt-get update && apt-get install -y nodejs npm
RUN npm install && npm run build

# 権限の調整
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

ENV PORT=80
EXPOSE 80

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
