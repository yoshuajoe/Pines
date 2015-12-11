import json
import string
#Author : Alfan F. Wicaksono
#IR Lab, FASILKOM, UI

#Script for selecting several tweets from corpus based on a keyword

######################### you can modify this part #############################

corpusFile = "polarity.json"
newFile    = "neutral.json"
keyword    = "neutral"

################################################################################

fin  = open(corpusFile, "r")
fout = open(newFile, "w")

heavy = json.loads(fin.read())
count = 550
res = []
for line in heavy:
    if count <= 1000:
	   if line['Polarity'] == keyword:  
            res.append(line)
    count += 1
	
fout.write(json.dumps(res))
fin.close()
fout.close()

