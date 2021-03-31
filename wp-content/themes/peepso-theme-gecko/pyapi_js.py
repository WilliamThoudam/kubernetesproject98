import requests
import simplejson as json
import sys

n = len(sys.argv)
#print("Total arguments passed: ", n)

#print("\nArgument passed: ", sys.argv[1].strip())

url = "http://127.0.0.1:3000/member_matches?userid=" + sys.argv[1].strip()

response = requests.get(url)
data = response.json()

print(data)

