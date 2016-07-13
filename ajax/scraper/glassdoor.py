import requests
import shutil
import json
import sys
import os

fname = sys.argv[1]
key = fname.replace('glassdoor-', '')
key = key.replace('.json', '')

os.chdir('../../public/uploads')
json_file = fname

if json_file in os.listdir():
    with open(json_file, 'r') as f:
        temp = json.load(f)
    url = temp['url']

    headers = {"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36"}
    res = requests.get(url, headers=headers, stream=True)

    with open('glassdoor-{}.png'.format(key), 'wb') as f:
        shutil.copyfileobj(res.raw, f)

    os.remove(json_file)
