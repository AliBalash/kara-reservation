#!/bin/bash

# Navigate to the directory with the car images
cd /Users/mac/Desktop/dodo1/public/assets/car-pics

# Loop through each .webp file and rename it
for file in *.webp; do
    # Replace spaces with hyphens
    new_name=$(echo "$file" | sed 's/ //g')
    # Rename the file
    mv "$file" "$new_name"
done
