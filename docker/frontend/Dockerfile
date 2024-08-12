FROM node:latest

# Install dependencies
RUN apt-get update && apt-get install -y \
    vim \
    zip \
    unzip \
    curl


#install tailwind
# Change current user
RUN groupadd -g 1001 www-data && useradd -u 1001 -ms /bin/bash -g www-data www-data
USER 1001
EXPOSE 5173

# https://github.com/vitejs/vite/discussions/3396
CMD ["sh", "-c", "npm install && npm run dev -- --host"]
