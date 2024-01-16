FROM node:latest

# Install dependencies
RUN apt-get update && apt-get install -y \
    vim \
    zip \
    unzip \
    curl

#install tailwind

RUN npm install -D tailwindcss
RUN npx tailwindcss init

# Change current user
USER node

EXPOSE 5173

# https://github.com/vitejs/vite/discussions/3396
CMD ["sh", "-c", "npm install && npm run dev -- --host"]