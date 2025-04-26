pipeline {
    agent any

    environment {
        IMAGE_NAME = "ghcr.io/waally-api:latest"
        CONTAINER_NAME = "wally-app"
        SERVER_USER = "root"
        SERVER_IP = "213.210.20.19"
        DEPLOY_PATH = "/var/app/prod/wally-app"
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
                    sh 'docker build --no-cache -t $IMAGE_NAME .'
                    withDockerRegistry([credentialsId: 'github-token', url: 'https://ghcr.io']) {
                        sh 'docker push $IMAGE_NAME'
                    }
                }
            }
        }

        stage('Deploy on VPS') {
            steps {
                script {
                    sshagent(['server-ssh-key']) {
                        sh """
                        ssh -o StrictHostKeyChecking=no $SERVER_USER@$SERVER_IP << 'EOF'
                        echo "🛠 Vérification du répertoire $DEPLOY_PATH"
                        if [ ! -d "$DEPLOY_PATH" ]; then
                            echo "Création du dossier projet!"
                            mkdir -p $DEPLOY_PATH
                        fi

                        echo "📂 Vérification du contenu du dossier Laravel..."
                        if [ -z "\$(ls -A $DEPLOY_PATH)" ]; then
                            echo "🚀 Copie des fichiers Laravel depuis le conteneur..."
                            CONTAINER_ID=\$(docker create $IMAGE_NAME)
                            docker cp \$CONTAINER_ID:/var/app/prod/sygpre/. $DEPLOY_PATH
                            docker rm \$CONTAINER_ID
                        fi

                        echo "🛠 Vérification du fichier .env"
                        if [ ! -f "$DEPLOY_PATH/.env" ]; then
                            echo "🚀 Création d'un fichier .env vide..."
                            touch $DEPLOY_PATH/.env
                            cp $DEPLOY_PATH/.env.example $DEPLOY_PATH/.env
                        fi

                        echo "🛠 Stopping old containers.."
                        docker-compose -f $DEPLOY_PATH/docker-compose.yml down || true

                        echo "🔄 Pulling latest image.."
                        docker pull $IMAGE_NAME

                        echo "🚀 Starting application..."
                        cd $DEPLOY_PATH
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
