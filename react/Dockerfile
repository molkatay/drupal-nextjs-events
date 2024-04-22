# Use an official Node.js runtime as a parent image
FROM node:18-alpine

# Set the working directory to /app
WORKDIR /app

# Copy package.json and package-lock.json to the working directory
COPY package*.json ./

# Install the project dependencies
RUN npm install

# Copy the contents of the local src directory to the working directory
COPY . .

# Build the Next.js application
RUN npm run build

# Expose the port that Next.js will run on
EXPOSE 3000

# Define the command to run your application
CMD ["npm", "start"]
