pipeline {
    agent any

    parameters {
        choice(name: 'ENVIRONMENT', choices: ['production', 'development'], description: 'Select deployment environment')
    }

    environment {
        IMAGE_NAME = "ghcr.io/waally-api:${params.ENVIRONMENT}-latest"
        CONTAINER_NAME = "wally-app-${params.ENVIRONMENT}"
        SERVER_USER = "root"
        SERVER_IP = "213.210.20.19"
        DEPLOY_PATH = "/var/app/${params.ENVIRONMENT}/wally-app"
    }

    stages {
        stage('Checkout Code') {
            steps {
                git branch: 'main', credentialsId: 'github_token', url: 'https://github.com/lecodeur228/waally-api.git'
            }
        }

        stage('Build & Push Docker Image') {
            steps {
                script {
                    sh "docker build --no-cache --build-arg ENV=${params.ENVIRONMENT} -t ${IMAGE_NAME} ."
                    withDockerRegistry([credentialsId: 'github-token', url: 'https://ghcr.io']) {
                        sh "docker push ${IMAGE_NAME}"
                    }
                }
            }
        }

        stage('Deploy on VPS') {
            steps {
                script {
                    sshagent(['server-ssh-key']) {
                        sh """
                        ssh -o StrictHostKeyChecking=no $SERVER_USER@$SERVER_IP << EOF
                        echo "🛠 Vérification du répertoire $DEPLOY_PATH"
                        if [ ! -d "$DEPLOY_PATH" ]; then
                            echo "Création du dossier projet!"
                            mkdir -p $DEPLOY_PATH
                        fi

                        # Copier les fichiers de configuration
                        echo "📂 Préparation des fichiers de configuration..."
                        echo "ENVIRONMENT=${params.ENVIRONMENT}" > $DEPLOY_PATH/.env
                        echo "IMAGE_NAME=${IMAGE_NAME}" >> $DEPLOY_PATH/.env
                        echo "CONTAINER_NAME=${CONTAINER_NAME}" >> $DEPLOY_PATH/.env

                        # Copier Docker Compose et configs Nginx
                        scp docker-compose.yml $SERVER_USER@$SERVER_IP:$DEPLOY_PATH/
                        scp -r docker $SERVER_USER@$SERVER_IP:$DEPLOY_PATH/

                        echo "🛠 Stopping old containers.."
                        cd $DEPLOY_PATH
                        docker-compose down || true

                        echo "🔄 Pulling latest image.."
                        docker pull $IMAGE_NAME

                        echo "🚀 Starting application..."
                        docker-compose up -d --force-recreate --build

                        echo "✅ Deployment complete!"
                        exit 0
EOF
                        """
                    }
                }
            }
        }
    }
}
