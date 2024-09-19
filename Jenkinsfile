pipeline {
    agent any

    environment {
        SCANNER_HOME = tool 'Sonar'  // Nom de l'installation SonarQube Scanner configurée dans Jenkins
    }

    stages {
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