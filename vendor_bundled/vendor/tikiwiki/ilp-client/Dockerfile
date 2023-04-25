FROM rjsmelo/ubuntu-php:7.4-qa
RUN apt-get -y update
RUN apt-get -y install curl dirmngr apt-transport-https lsb-release ca-certificates vim
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -
RUN apt-get -y install nodejs
RUN git clone https://github.com/interledgerjs/ilp-spsp-invoice-server.git /ilp-spsp-invoice-server
RUN npm install -g pm2@latest moneyd ilp-spsp
RUN npm install /ilp-spsp-invoice-server
