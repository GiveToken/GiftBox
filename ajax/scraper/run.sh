#!/bin/sh
# runs the scrapers

if [ "$#" -gt 0 ]
then
  source venv/bin/activate
  if [ $1 == 'glassdoor' ]
  then
    python3 glassdoor.py $2
  fi
  if [ $1 == 'linkedin' ]
  then
    python3 linkedin.py $2
  fi
  deactivate
fi
