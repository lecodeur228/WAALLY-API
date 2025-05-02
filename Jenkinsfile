pipeline {
    agent any

    environment {
        IMAGE_NAME = "ghcr.io/lecodeur228/waally-api:latest"
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
                    withDockerRegistry([credentialsId: 'github_token', url: 'https://ghcr.io']) {
                        sh 'docker push $IMAGE_NAME'
                    }
                }
            }
        }

        stage('Deploy on VPS') {
            steps {
                script {
                    // Utilisation de l'identifiant d'authentification SSH pour exécuter les commandes distantes
                    sshagent(['server-ssh-key']) {
                        sh """
                            ssh -o StrictHostKeyChecking=no $SERVER_USER@$SERVER_IP << 'EOF'
                            set -e

                            echo "🛠 Vérification du répertoire $DEPLOY_PATH"
                            if [ ! -d "$DEPLOY_PATH" ]; then
                                echo "📁 Création du dossier de déploiement..."
                                mkdir -p $DEPLOY_PATH
                            fi

                            echo "📂 Vérification du contenu du dossier Laravel..."
                            if [ -z "\$(ls -A $DEPLOY_PATH)" ]; then
                                echo "🚀 Copie des fichiers Laravel depuis le conteneur Docker..."
                                CONTAINER_ID=\$(docker create $IMAGE_NAME)
                                docker cp \$CONTAINER_ID:/var/app/prod/wally-app/. $DEPLOY_PATH
                                docker rm \$CONTAINER_ID
                            fi

                            echo "🛑 Arrêt des anciens conteneurs..."
                            docker compose -f $DEPLOY_PATH/docker-compose.yml down || true

                            echo "🔄 Récupération de la dernière image Docker..."
                            docker pull $IMAGE_NAME

                            echo "🚀 Démarrage de l'application..."
                            cd $DEPLOY_PATH
                            docker compose up -d --force-recreate --build

                            echo "✅ Déploiement terminé avec succès !"
                            EOF
                        """
                    }
                }
            }
        }
    }
}
