# --- Stage 1: Build ---
FROM node:20-slim AS build

WORKDIR /app

# Copie des fichiers de dépendances
COPY package*.json ./

# Installation des dépendances
RUN npm install

# Copie du reste du code source
COPY . .

# Build de l'application Nuxt
RUN npm run build

# --- Stage 2: Run ---
FROM node:20-slim AS runtime

WORKDIR /app

# On ne copie que les dossiers nécessaires au runtime de Nuxt 3/4
COPY --from=build /app/.output ./.output

# Nuxt écoute par défaut sur le port 3000
EXPOSE 3000

# Commande de lancement
CMD ["node", ".output/server/index.mjs"]