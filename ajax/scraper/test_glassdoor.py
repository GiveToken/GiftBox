from unittest import TestCase, main
import requests
import shutil
import os

class TestGlassdoor(TestCase):
    def setUp(self):
        os.chdir('../../public/uploads')
        self.link = 'https://media.glassdoor.com/sqll/12830/vmware-squarelogo-1450108409867.png'
        self.key = 'x5vux6xlck'
        self.fname = 'glassdoor-{}.png'.format(self.key)

    def test_download(self):
        headers = {"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36"}
        res = requests.get(self.link, headers=headers, stream=True)
        with open(self.fname, 'wb') as f:
            shutil.copyfileobj(res.raw, f)
        self.assertIn(self.fname, os.listdir())

    def tearDown(self):
        os.remove(self.fname)

if __name__ == '__main__':
    main()
