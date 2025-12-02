#!/bin/bash
# Script to download CA certificates for Composer if needed
# This can be used in buildpacks or deployment scripts

# Download latest CA bundle from curl
if [ ! -f "cacert.pem" ]; then
    echo "Downloading CA certificates..."
    curl -o cacert.pem https://curl.se/ca/cacert.pem
    
    if [ -f "cacert.pem" ]; then
        # Set as Composer CA file
        export COMPOSER_CAFILE="$(pwd)/cacert.pem"
        echo "CA certificates downloaded and configured"
    else
        echo "Warning: Could not download CA certificates"
    fi
fi

