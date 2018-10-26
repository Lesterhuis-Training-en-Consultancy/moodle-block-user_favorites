pipeline {
    agent any
    triggers {
        pollSCM('H */10 * * *')
    }
    stages {
        stage('Init') {
            steps {
                echo 'Testing the plugin '
            }
        }

        stage("build") {
            steps {
                script {
                    docker.withServer('tcp://192.168.32.25:4243') {
                        docker.image('moodlefreak/docker-md:moodle35').inside('-u root'){
                            sh 'php -v'
                            sh 'ls -lat'
                            sh 'pwd'
                            sh 'mkdir -p /var/www/html/blocks/user_favorites'
                            sh 'cp -R . /var/www/html/blocks/user_favorites'
                            sh "cd /var/www/html/blocks/user_favorites && git grep -I --name-only -z -e '' | xargs -0 sed -i 's/[ \\t]\\+\\(\\r\\?\\)\$/\\1/'"

                            stage("plugin-test") {
                                sh 'cd /var/www/html/ && bash plugin-test.sh blocks/user_favorites'
                            }
                        }
                    }
                }
            }
        }
    }
}