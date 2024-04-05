#!/bin/bash
# exit on error
set -o errexit

python3 -m pip install -r requirements.txt

echo "Collecting static files"
python3 manage.py collectstatic --no-input

echo "Applying database migrations"
python3 manage.py makemigrations
python3 manage.py migrate --noinput

echo "Starting the server using daphne"
python3 manage.py runserver 0.0.0.0:8000

export BASICAUTH=$(echo 'triest:Triestje88' | base64)
