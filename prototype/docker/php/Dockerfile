#++++++++++++++++++++++++++++++++++++++
# PHP application Docker container
#++++++++++++++++++++++++++++++++++++++

FROM panosru/php:latest-dev


RUN curl -Lsf 'https://storage.googleapis.com/golang/go1.8.3.linux-amd64.tar.gz' | tar -C '/usr/local' -xvzf -
ENV PATH /usr/local/go/bin:$PATH
RUN go get github.com/mailhog/mhsendmail
RUN cp /root/go/bin/mhsendmail /usr/bin/mhsendmail


ENV PROVISION_CONTEXT "development"

# Add User
ENV APPLICATION_USER=application \
    APPLICATION_GROUP=application \
    APPLICATION_PATH=/app \
    APPLICATION_UID=1000 \
    APPLICATION_GID=1000

# Add group
RUN groupadd -g "$APPLICATION_GID" "$APPLICATION_GROUP"

# Add user
RUN useradd -u "$APPLICATION_UID" --home "/home/application" --create-home --shell /bin/bash --no-user-group "$APPLICATION_USER"

# Assign user to group
RUN usermod -g "$APPLICATION_GROUP" "$APPLICATION_USER"

RUN chown -R www-data:www-data /var/www/html

# Set Volumes
VOLUME ["/var/www/html", "/usr/local/etc", "/tmp/debug"]

# Configure volume/workdir
WORKDIR /var/www/html
