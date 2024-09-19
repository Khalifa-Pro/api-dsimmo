pipeline {
    agent any

    environment {
        SCANNER_HOME = tool 'Sonar'  // Nom de l'installation SonarQube Scanner configurée dans Jenkins
    }

    stages {
        stage('Install Node.js') {
            steps {
                // Vérifier si Node.js est installé et l'installer si nécessaire
                sh '''
                    if ! [ -x "$(command -v node)" ]; then
                        echo "Node.js n'est pas installé. Installation en cours..."
                        curl -sL https://deb.nodesource.com/setup_16.x | sudo -E bash -
                        sudo apt-get install -y nodejs
                    else
                        echo "Node.js est déjà installé : $(node -v)"
                    fi
                '''
            }
        }

        stage('SonarQube Analysis - Laravel') {
            steps {
                script {
                    // Exécuter l'analyse avec SonarQube Scanner
                    withSonarQubeEnv('SonarQube') {  // Nom du serveur SonarQube configuré dans Jenkins
                        sh "${SCANNER_HOME}/bin/sonar-scanner -Dsonar.projectKey=test-api-dsimmo -Dsonar.sources=. -Dsonar.host.url=http://172.17.0.3:9000 -Dsonar.login=sqp_83f08e190bb21a39ba1a02628c277d9d9e0ca089"
                    }
                }
            }
        }

        stage('Quality Gate') {
            steps {
                script {
                    // Attendre et vérifier le résultat du Quality Gate de SonarQube
                    timeout(time: 1, unit: 'HOURS') {
                        waitForQualityGate abortPipeline: true
                    }
                }
            }
        }
    }

    post {
        always {
            // Nettoyer l'espace de travail après chaque build
            cleanWs()
        }
        success {
            echo 'Build succeeded!'
        }
        failure {
            echo 'Build failed!'
        }
    }
}
