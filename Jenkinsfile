pipeline {
    agent any
    stages {
        stage('Build/Deploy app to staging') {
            steps {
                sshPublisher(
                    publishers: [
                        sshPublisherDesc(
                            configName: 'staging',
                            transfers: [
                                sshTransfer(
                                    cleanRemote: false, 
                                    excludes: '', 
                                    execCommand: 'echo \'Replace me by your build/install scripts\'', 
                                    execTimeout: 120000, 
                                    flatten: false, 
                                    makeEmptyDirs: false, 
                                    noDefaultExcludes: false, 
                                    patternSeparator: '[, ]+', 
                                    remoteDirectory: '', 
                                    remoteDirectorySDF: false, 
                                    removePrefix: '', 
                                    sourceFiles: '**/*'
                                )
                            ], 
                            usePromotionTimestamp: false,
                            useWorkspaceInPromotion: false, 
                            verbose: true
                        )
                    ]
                )
            }
        }
        stage('Run automated tests') {
            steps {
                // One or more steps need to be included within the steps block.
                echo 'Despertador IoT pipeline - run automated tests'
            }
        }
        stage('Perform manual testing') {
            steps {
                // One or more steps need to be included within the steps block.
                // echo 'Despertador IoT pipeline - manual testing'
                timeout(activity: true, time: 5) {
                    input 'Proceed to production?'
                }
            }
        }
        stage('Release to production') {
            steps {
                // One or more steps need to be included within the steps block.
                echo 'Despertador IoT pipeline - release to production'
            }
        }
    }
}

