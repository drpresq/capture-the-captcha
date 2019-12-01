'''
solver.py: CAPTCHA Decoder Demo Script
'''
from __future__ import division
from PIL import Image,ImageChops
from operator import itemgetter
import hashlib,time
import cStringIO,glob
import math,os,requests,socket,fcntl,struct

#########################################################################
#
#                 CAPTURE THE CAPTCHA: Decoder Demo Script
# By: George Wood (gwwood@miners.utep.edu || github.com/drpresq/capture-the-captcha)
#
#                     Code based on original works by:
#             Ben Boyter (https://boyter.org/decoding-captchas/)
#           Rahul Sasi (http://garage4hackers.com/entry.php?b=3103)
#
#                             Inspired by:
#         Mark Baggett (https://www.sans.org/instructors/mark-baggett)
#             Joff Thyer (https://www.linkedin.com/in/joffthyer/)
#               SANS SEC573 Python for Penetration Testers
#
#          Set the variables directly below to adjust script behavior
#########################################################################

# Boolean Switches:
train = False        # Save letter slices to make a training set for the algo; if false, the algo will attempt to solve the CAPTCHA 
testImages = False   # Save a copy of the filtered image (useful when working out what pix values to set below)
post = True        # POST the attempted CAPTCHA solution to url2

# Number of times you want the Script to Train or Solve
stop = 10

# List of Characters represented in your training set
iconset = ['0','1','2','3','4','5','6','7','8','9','0',
  'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z']
  #'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z']

# The name of the CAPTCHA variable from the CAPTCHA submission Form at url2
captchaVar = 'captcha'

# Pixel Values set these to tell the script what color the CAPTCHA letters are
# (you'll see the possible values in the histogram that prints when the script runs; takes some trial and error)
pix1 = 1  # 1 is black
pix2 = 1

# Helper fucntion to auto return interface ip address
def get_ip_address(ifname):
    s = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
    return socket.inet_ntoa(fcntl.ioctl(
        s.fileno(),
        0x8915,  # SIOCGIFADDR
        struct.pack('256s', ifname[:15])
    )[20:24])

# Url to CAPTCHA generator
url = 'http://'+get_ip_address("enp0s3")+'/captcha/decode1/captcha1.php'

# Url to page accepting CAPTCHA
url2 = 'http://'+get_ip_address("enp0s3")+'/captcha/decode1/index.php'

# Classes and helper functions
class VectorCompare:
  def magnitude(self,concordance):
    total = 0
    for word,count in concordance.iteritems():
      total += count ** 2
    return math.sqrt(total)

  def relation(self,concordance1, concordance2):
    topvalue = 0
    for word, count in concordance1.iteritems():
      if concordance2.has_key(word):
        topvalue += count * concordance2[word]
    return topvalue / (self.magnitude(concordance1) * self.magnitude(concordance2))

def buildImageSet(iconset):
  imageset = []
  for letter in iconset:
    for img in os.listdir('./training/%s/'%(letter)):
      temp = []
      if img != "Thumbs.db": # windows check...
        temp.append(buildvector(Image.open("./training/%s/%s"%(letter,img))))
      imageset.append({letter:temp})
  return imageset

def buildvector(im):
  d1 = {}
  count = 0
  for i in im.getdata():
    d1[count] = i
    count += 1
  return d1

def printHistogram(captcha_image):
  # print the histogram of pixel concentration
  his = captcha_image.histogram()
  values = {}
  for i in range(256):
    values[i] = his[i]
  print "[-] Image pixel concentration \n"  
  for color,concentrate in sorted(values.items(), key=itemgetter(1), reverse=True)[:10]:
    print color,concentrate

def isolateLettersFromNoise(captcha_image, captcha_filtered, pix1=204, pix2=205):
  # Isolate the letters from the noise
  for x in range(captcha_image.size[1]):
    for y in range(captcha_image.size[0]):
      pix = captcha_image.getpixel((y,x))
      temp[pix] = pix
      if pix == pix1 or pix == pix2: # these are the numbers to get
        captcha_filtered.putpixel((y,x),0)
  return captcha_filtered

def findIndividualLetters(captcha_filtered):
  # Find infividual letters
  inletter = False
  foundletter = False
  start = 0
  end = 0

  letters = []

  for y in range(captcha_filtered.size[0]): # slice across
    for x in range(captcha_filtered.size[1]): # slice down
      pix = captcha_filtered.getpixel((y,x))
      if pix != 255:
        inletter = True
    if foundletter == False and inletter == True:
      foundletter = True
      start = y

    if foundletter == True and inletter == False:
      foundletter = False
      end = y
      letters.append((start,end))

    inletter=False

  return letters

def createTrainingImages(letters, captcha_filtered):
  count = 0
  for letter in letters:
    m = hashlib.md5()
    im3 = captcha_filtered.crop(( letter[0] , 0, letter[1],captcha_filtered.size[1] ))
    m.update("%s%s"%(time.time(),count))
    im3.save("./training/%s.gif"%(m.hexdigest()))
    count += 1

def compareTrainingImages(letters, captcha_filtered, imageset, train):
  count = 0
  guessword = ""
  for letter in letters:
    im3 = captcha_filtered.crop(( letter[0] , 0, letter[1],captcha_filtered.size[1] ))
    #Match current letter with sample data
    guess = []
    for image in imageset:
      for x,y in image.iteritems():
        if len(y) != 0:
          guess.append( ( v.relation(y[0],buildvector(im3)),x) )

    guess.sort(reverse=True)
    if (train):
      print "",guess[0]
    guessword = "%s%s"%(guessword,guess[0][1])

    count += 1
  return guessword

# Variable Declarations:

v = VectorCompare()

imageset = buildImageSet(iconset)

session = requests.session()

counter = 0

start = time.time()
   
#lets make X request read captcha 
for x in range(1,stop):
  
  # Get the CAPTCHA image  
  response = session.get(url)
  length = response.headers['content-length']
  
  # read the captch and we will save them with there content length */
  if(train):
    print "[-] Image Content length " , length
  image_read = response.content
  
  # cStringIO to create an object from memmory
  image_read = cStringIO.StringIO(image_read)
  captcha_image = Image.open(image_read)
  captcha_image = captcha_image.convert("P")
  temp = {}
  captcha_filtered = Image.new("P",captcha_image.size,255)
  
  if (train):
    # Print Histogram
    printHistogram(captcha_image)
  
  # Isolate Letters from Noise
  captcha_filtered = isolateLettersFromNoise(captcha_image, captcha_filtered, pix1, pix2)

  # save a copy of the filtered image; useful when trying to figure out which pix to set
  if (testImages):
    captcha_filtered.save("./testimages/"+length+".gif")

  # Find the individual letters
  letters = findIndividualLetters(captcha_filtered)
  
  if (train):
    print "[-] Horizontal Position Where letter start and stop \n"  
    print letters
    print "\n"

  if (train):
    # Slice letters out and make a training set
    createTrainingImages(letters, captcha_filtered)

  else:
    # Slice letters out and compare to training set
    guessword = compareTrainingImages(letters, captcha_filtered, imageset, train)
    print "[*] Captcha Guess is %s"%(guessword)

  if (post):
    #let us post the captcha to the server along with the session token
    data = {captchaVar : guessword}
    response = session.post(url2, data)
    correct = "[+] CAPTCHA Correct!"
    if("Incorrect" in response.content):
      correct = "[-] Captcha Incorrect"
      counter = counter+1
    print "%s\n\n%s\n\n"%(correct,response.content)

if(post):
  print "\n\nThere were %x correct responses out of %s.\nSuccess Rate: %s" % ( (stop-counter) , stop , str(int(((stop-counter)/stop)*100))+"%")
  print "Elapse Time: %s minutes, %s seconds" %(int((time.time()-start)/60),int((time.time()-start)%60))