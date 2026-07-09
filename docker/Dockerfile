FROM php:8.3-fpm

# ───────────────────────────────
# 🟦 PHP configuration
# ───────────────────────────────
COPY php/php.ini /usr/local/etc/php/conf.d/opcache.ini
COPY php/www.conf /usr/local/etc/php-fpm.d/www.conf

# ───────────────────────────────
# 🧰 Redis configuration
# ───────────────────────────────
COPY redis/redis.conf /usr/local/etc/redis/redis.conf

# ───────────────────────────────
# 📦 Install dependencies & fix permissions
# ───────────────────────────────
COPY scripts/install/ /usr/local/bin/scripts/install/
RUN chmod +x /usr/local/bin/scripts/install/*.sh \
    && chmod +x /usr/local/bin/scripts/install/tasks/*.sh \
    && /usr/local/bin/scripts/install/dependencies.sh

# ───────────────────────────────
# 🔐 Permissions scripts
# ───────────────────────────────
COPY scripts/bootstrap/ /usr/local/bin/scripts/bootstrap/
RUN chmod +x /usr/local/bin/scripts/bootstrap/*.sh \
    && chmod +x /usr/local/bin/scripts/bootstrap/composer/*.sh \
    && /usr/local/bin/scripts/bootstrap/permissions.sh

# ───────────────────────────────
# 🌍 Working directory
# ───────────────────────────────
WORKDIR /var/www

# ───────────────────────────────
# ⚙️ Entrypoints & bootstrap scripts
# ───────────────────────────────
COPY scripts/entrypoints/ /usr/local/bin/scripts/entrypoints/
RUN find /usr/local/bin/scripts/entrypoints/ -type f -name "*.sh" -exec chmod +x {} \;

COPY scripts/run.sh /usr/local/bin/scripts/run.sh
RUN chmod +x /usr/local/bin/scripts/run.sh

# ───────────────────────────────
# 🚀 Set entrypoint & command
# ───────────────────────────────
ENTRYPOINT ["/usr/local/bin/scripts/run.sh"]
CMD []
