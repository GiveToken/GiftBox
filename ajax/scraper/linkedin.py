from bs4 import BeautifulSoup
from urllib.request import urlretrieve
import requests
import json
import sys
import os
import re

class LinkedInScraper(object):
    """Web scraper for LinkedIn public company pages"""

    def __init__(self, url):
        self.url = url
        self.media_prefix = "https://media.licdn.com/media/"
        self.company = {}

    def get_source(self):
        """Retrieves the HTML source of the page"""
        headers = {"User-Agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36"}
        response = requests.get(self.url, headers=headers)
        html = response.content.decode("utf-8")
        return html

    def parse_html(self):
        """Parses HTML source for the JSON section"""
        source = self.get_source()
        soup = BeautifulSoup(source, "html.parser")
        soup.encode("utf-8")
        result = soup.find_all("code", {"id":"stream-feed-embed-id-content"})
        return result

    def convert_json(self):
        """Prepares the raw HTML source for JSON encoding with
        string and regular expression replacements
        """
        parsed_html = self.parse_html()
        if len(parsed_html) != 0:
            raw_html = str(parsed_html[0])

            raw_html = raw_html.replace("<!--", "")
            raw_html = raw_html.replace("-->", "")
            raw_html = re.sub("(</?code>)", "", raw_html)
            raw_html = re.sub("(</?code.*?>)", "", raw_html)

            for char in raw_html:
                if char == "\n" or char == "\r":
                    raw_html = raw_html.replace(char, "")
                elif char == "’":
                    raw_html = raw_html.replace(char, "'")

            return json.loads(raw_html)
        return None

    def get_company_data(self, key):
        """Retrieves JSON information from the HTML source and
        populates the company JSON object accordingly
        """
        json = self.convert_json()
        if json != None:
            try:
                self.company["name"] = json["companyName"]
            except KeyError:
                self.company["name"] = ""

            try:
                self.company["description"] = json["description"]
            except KeyError:
                self.company["description"] = ""

            try:
                self.company["legacyLogo"] = json["legacySquareLogo"]
                if "description" in self.company.keys():
                    legacy_url = self.media_prefix + self.company["legacyLogo"]
                    urlretrieve(legacy_url, "legacyLogo-%s.png" % key)
            except KeyError:
                self.company["legacyLogo"] = ""

            try:
                self.company["heroImage"] = json["heroImage"]
                if "description" in self.company.keys():
                    hero_image_url = self.media_prefix + self.company["heroImage"]
                    urlretrieve(hero_image_url, "heroImage-%s.png" % key)
            except KeyError:
                self.company["heroImage"] = ""

            try:
                self.company["url"] = self.url
            except KeyError:
                self.company["url"] = ""

            try:
                self.company["key"] = key
            except KeyError:
                self.company["key"] = ""

            return self.company
        return None

if __name__ == "__main__":
    # 10 length alphanumerical key
    fname = sys.argv[1]
    os.chdir("../../public/uploads")
    if fname in os.listdir():
        # run the scraper
        with open(fname) as json_raw:
            temp = json.load(json_raw)
        url = temp["url"]
        scraper = LinkedInScraper(url)

        # extract the key
        key = fname.replace("temp-", "")
        key = key.replace(".json", "")

        data = scraper.get_company_data(key)

        # clean up
        os.remove(fname)
        print(json.dumps(data))
    else:
        pass
