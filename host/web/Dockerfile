# Используем Node.js для сборки Vue.js приложения
FROM node:lts-alpine AS build-stage
WORKDIR /app
COPY ./web/package*.json ./
RUN npm install
COPY ./web .
RUN npm run build

# Используем Nginx для статического хостинга
FROM nginx:stable-alpine AS production-stage
COPY --from=build-stage /app/dist /usr/share/nginx/html

# Копируем конфигурацию Nginx
COPY ./host/web/nginx.conf /etc/nginx/nginx.conf

# Экспонируем порт 80
EXPOSE 80

# Запускаем Nginx
CMD ["nginx", "-g", "daemon off;"]