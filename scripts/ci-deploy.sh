#! /bin/bash
set -e

COMMIT_SHA1=$CIRCLE_SHA1

export COMMIT_SHA1=$COMMIT_SHA1

envsubst <./kube/wissen-backend-deployment.yml >./kube/wissen-backend-deployment.yml.out
mv ./kube/wissen-backend-deployment.yml.out ./kube/wissen-backend-deployment.yml

echo "$KUBERNETES_CLUSTER_CERTIFICATE" | base64 --decode > cert.crt

./kubectl \
  --kubeconfig=/dev/null \
  --server=$KUBERNETES_SERVER \
  --certificate-authority=cert.crt \
  --token=$KUBERNETES_TOKEN \
  apply -f ./kube/
