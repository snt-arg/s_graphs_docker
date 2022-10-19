#!/bin/bash

URL=""

echo "Begining the download"
wget --no-check-certificate "$URL" -O real_dataset.bag
