#!/bin/ash
GREEN="\033[0;32m"
YELLOW="\033[1;33m"
RED="\033[0;31m"
RESET="\033[0m"

log_success() {
    echo -e "${GREEN}[Успешно!] $1${RESET}"
}

log_warning() {
    echo -e "${YELLOW}[Предупреждение!] $1${RESET}"
}

log_error() {
    echo -e "${RED}[Ошибка!] $1${RESET}"
}

echo "⏳ Очистка временных файлов..."
if rm -rf /home/container/tmp/*; then
    log_success "Временные файлы успешно удалены."
else
    log_error "Не удалось удалить временные файлы."
    exit 1
fi

echo "⏳ Запуск PHP-FPM..."
if /usr/sbin/php-fpm8 --fpm-config /home/container/php-fpm/php-fpm.conf --daemonize; then
    log_success "PHP-FPM успешно запущен."
else
    log_error "Не удалось запустить PHP-FPM."
    exit 1
fi

echo "⏳ Запуск Nginx..."
log_success "Веб-сервер запущен. Все службы успешно запущены."
/usr/sbin/nginx -c /home/container/nginx/nginx.conf -p /home/container/

tail -f /dev/null
