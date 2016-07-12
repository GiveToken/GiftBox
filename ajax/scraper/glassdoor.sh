#!/bin/sh
# runs the glassdoor script

if [ "$#" -gt 0 ]
then
  source venv/bin/activate
  python3 glassdoor.py $1
  deactivate
fi
