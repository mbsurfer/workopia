# Use the official Node.js image as the base image
FROM node:16

# Set the working directory
WORKDIR /app

# Copy package.json
COPY src/package.json .

# Install dependencies
RUN npm install

# Copy the rest of the application code
COPY . .

# Run Vite development server
CMD ["npm", "run", "dev"]
