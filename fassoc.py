import json
import time
import random
import string
import re
import codecs
import vincent
import pandas as pd
import operator
import sys

from collections import defaultdict
from collections import Counter 
from nltk.tokenize import word_tokenize

class CountTweet(object):
	def __init__(self):
		self.tweetMonth = {"Jan":[],"Feb":[],"Mar":[],"Apr":[],"May":[],"Jun":[],"Jul":[],"Aug":[],"Sep":[],"Oct":[],"Nov":[], "Dec":[]}
	
	def split(self, filename):
		f = open(filename, 'r')
		for line in f:
			line = line.strip()
			tweets = json.loads(line)
			t = tweets['created_at'].split(" ")
			if(t[1] == "Jan"):
				self.tweetMonth["Jan"].append(tweets)
			elif(t[1] == "Feb"):
				self.tweetMonth["Feb"].append(tweets)
			elif(t[1] == "Mar"):
				self.tweetMonth["Mar"].append(tweets)
			elif(t[1] == "Apr"):
				self.tweetMonth["Apr"].append(tweets)
			elif(t[1] == "May"):
				self.tweetMonth["May"].append(tweets)
			elif(t[1] == "Jun"):
				self.tweetMonth["Jun"].append(tweets)
			elif(t[1] == "Jul"):
				self.tweetMonth["Jul"].append(tweets)
			elif(t[1] == "Aug"):
				self.tweetMonth["Aug"].append(tweets)
			elif(t[1] == "May"):
				self.tweetMonth["May"].append(tweets)
			elif(t[1] == "Sep"):
				self.tweetMonth["Sep"].append(tweets)
			elif(t[1] == "May"):
				self.tweetMonth["May"].append(tweets)
			elif(t[1] == "Oct"):
				self.tweetMonth["Oct"].append(tweets)
			elif(t[1] == "Nov"):
				self.tweetMonth["Nov"].append(tweets)
			elif(t[1] == "Dec"):
				self.tweetMonth["Dec"].append(tweets)
		return self.tweetMonth
	
	def wordCount(self, clean_tweets, count):
		count_all = Counter()
		for ctw in clean_tweets:
			if ctw['text_clean'] != None:
				terms_all = ctw['text_clean'].split(" ")
				count_all.update(terms_all)
		return count_all.most_common(count)
		
	def fromTuplesToJson(self, wc):
		js = []
		for w in wc:
			js.append({"word":w[0],"weight":w[1]})
		return js
		
	def count(self, tweets):
		countM = {"Jan":0,"Feb":0,"Mar":0,"Apr":0,"May":0,"Jun":0,"Jul":0,"Aug":0,"Sep":0,"Oct":0,"Nov":0, "Dec":0}
		for tw in tweets:
			countM[tw] = len(tweets[tw]) 
		return countM
	
	def countPerDay(self, tweets, month):
		enum = {"Jan":31, "Feb":28, "Mar":31, "Apr":30 , "May":31, "Jun":30, "Jul":31, "Aug":31, "Sep":30, "Oct":31, "Nov":30, "Dec":31}
		month_tweets = tweets[month]
		sor = sorted(month_tweets, key=lambda x:x['created_at'][2], reverse=False)
		lst = {1:0}
		
		for i in range(enum[month]):
			lst[i+1] = 0
		
		for i in range(enum[month]):
			for tw in tweets[month]:
				t = tw['created_at'].split(" ")
				if(int(t[2]) == (i+1)):
					lst[i+1] = lst[i+1] + 1
		return lst
	
	def avgcount(self, tweets):
		countavgM = {"Jan":0,"Feb":0,"Mar":0,"Apr":0,"May":0,"Jun":0,"Jul":0,"Aug":0,"Sep":0,"Oct":0,"Nov":0, "Dec":0}
		enum = {"Jan":31, "Feb":28, "Mar":31, "Apr":30 , "May":31, "Jun":30, "Jul":31, "Aug":31, "Sep":30, "Oct":31, "Nov":30, "Dec":31}
		for tw in tweets:
			countavgM[tw] = len(tweets[tw]) * 1.00 / enum[tw]
		return countavgM
	
	def writeFile(self, filename, json):
		f = open(filename,'w')
		f.write(json) # python will convert \n to os.linesep
		f.close()
	
	def top_mentioned(self, tweets, count):
		count_all = Counter()
		for ctw in tweets:
			for ct in tweets[ctw]:
				text = ct['text_clean'].encode("utf-8", errors='ignore')
				terms_all = [term for term in text.split(" ") if term.startswith('@')]
				count_all.update(terms_all)
		return count_all.most_common(count)
	
	def top_hash(self, tweets, count):
		count_all = Counter()
		for ctw in tweets:
			for ct in tweets[ctw]:
				text = ct['text_clean'].encode("utf-8", errors='ignore')
				terms_all = [term for term in text.split(" ") if term.startswith('#')]
				count_all.update(terms_all)
		return count_all.most_common(count)
	
	def coocurence(self, search_word, clean_tweets):
		com = defaultdict(lambda : defaultdict(int))
		
		# f is the file pointer to the JSON data set
		for tw in clean_tweets:
			if tw['text_clean'] != None:
				tweet = tw['text_clean']
			else:
				tweet = ""
			terms_only = [term for term in tweet.split(" ") if term != ""]
 
		# Build co-occurrence matrix
		for i in range(len(terms_only)-1):            
			for j in range(i+1, len(terms_only)):
				w1, w2 = sorted([terms_only[i], terms_only[j]])                
				if w1 != w2:
					com[w1][w2] += 1
					
		com_max = []
		# For each term, look for the most common co-occurrent terms
		for t1 in com:
			t1_max_terms = max(com[t1].items(), key=operator.itemgetter(1))[:5]
			for t2 in t1_max_terms:
				com_max.append(((t1, t2), com[t1][t2]))
				# Get the most frequent co-occurrences
		terms_max = sorted(com_max, key=operator.itemgetter(1), reverse=True)
		
		 # pass a term as a command-line argument
		count_search = Counter()
		for tw in clean_tweets:
			if tw['text_clean'] != None:
				tweet = tw['text_clean']
			else:
				tweet = ""
			terms_only = [term for term in tweet.split(" ") if term != ""]
			if search_word in terms_only:
				count_search.update(terms_only)
		buff = []
		for tup in count_search.most_common(10):
			if tup[0] != search_word:
				buff.append(tup)
		return buff
	
	def getAssocTW(self, tracker, topwords, count, depth, clean_tweets):	
		big = {"name":tracker, "children":[]}
		c = 0
		for tup in topwords:
			big["children"].append({"name":tup[0], "children":[]})
			coocur = self.coocurence(tup[0], clean_tweets)
			#print(len(coocur))
			for coo in coocur:
				if(coo[0] != tracker):
					big["children"][c]['children'].append({"name":coo[0], "size":1})
					coocur_2 = self.coocurence(coo[0], clean_tweets)
			c = c + 1
		dump = json.dumps(big)
		self.writeFile("data/data_viz/flare.json", dump)
		#return coocur
	
	def getAssocTW_neo(self,keyword, count, depth, clean_tweets):	
		asset = []
		if count == depth:
			coocur = self.coocurence(keyword, clean_tweets)
			assets = []
			for coo in coocur:
				assets.append({"name":coo[0], "size":coo[1]})
			return assets
		elif count < depth:
			coocur = self.coocurence(keyword, clean_tweets)
			c = 0
			for coo in coocur:
				asset.append({"name":coo[0], "size":coo[1], "children":[]})
				asset[c]["children"] = self.getAssocTW_neo(coo[0], count+1, depth, clean_tweets)
				c += 1
			return asset
			
	def top_influencer(self, tweets, count):
		count_all = Counter()
		for ctw in tweets:
			for ct in tweets[ctw]:
				screen_name = [ct['user']['screen_name'].encode("utf-8", errors='ignore')]
				count_all.update(screen_name)
		return count_all.most_common(count)
	
			
	def geoMap(self, tweets, month):
		# Tweets are stored in "fname"
		geo_data = {
			"type": "FeatureCollection",
			"features": []
		}
		for tweet in tweets[month]:
			if tweet['coordinates']:
				geo_json_feature = {
					"type": "Feature",
					"geometry": tweet['coordinates'],
					"properties": {
						"text": tweet['text'],
						"created_at": tweet['created_at']
					}
				}
				geo_data['features'].append(geo_json_feature)
	 
		# Save geo data
		with open('geo_data.json', 'w') as fout:
			fout.write(json.dumps(geo_data, indent=4))

word = None
trackerName = ""
depthTree = 1
for sy in sys.argv:
	word = sy.split("=")
	if word[0] == "-tracker":
		trackerName = word[1]
	if word[0] == "-depth":
		depthTree = int(word[1])


try:
	co = CountTweet()
	#while True:
	#clean = co.clean(asd)
	#print("Cleanse tweets ....")
	f = open("data/data_viz/datas.json", "r")
	clean = json.loads(f.read())
	#print(clean[0]['text_clean'])
	wc = co.wordCount(clean, 50)
	print("Constructing word cloud ....")
	#tmen = co.top_mentioned(asd, 10)
	#print("Who mentions me ....")
	#hasht = co.top_hash(asd, 5)
	#print("#Hashtag ....")
	#topin = co.top_influencer(asd, 10)
	#print("Who's there (Influencer) ....")
	#countpd = co.countPerDay(asd, "Oct")
	#print("Count per day ....")
	#jsonw = json.dumps(co.fromTuplesToJson(wc))
	#print("Stark analyzes the tweets  ....")
	#sentimen = co.sentimentAnalysis(clean)
	print("Find association ....")
	bigs = {"name":trackerName, "size":1, "children":[]}
	bg = co.getAssocTW_neo(trackerName.lower(),0,depthTree, clean)
	bigs["children"] = bg
	dump = json.dumps(bigs, check_circular=False)
	co.writeFile("data/data_viz/flare.json", dump)
except KeyboardInterrupt:
	exit()

#time_chart = vincent.Line(ITAvWAL)
#time_chart.axis_titles(x='Time', y='Freq')
#time_chart.to_json('time_chart.json')