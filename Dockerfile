FROM webdevops/php-nginx:7.4

COPY --chown=application . /app
WORKDIR /app

# Choose dependency manager (If you  use composer you need the 2nd one!)
# RUN php uppm.php install
RUN composer install

ENV WEB_DOCUMENT_ROOT=/app/public
ENV WEB_DOCUMENT_INDEX=index.php

# Actually the default command
CMD supervisord