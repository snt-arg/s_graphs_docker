#!/bin/bash

URL=""

echo "Begining the download"
wget --no-check-certificate "$URL" -O virtual_dataset.bag
