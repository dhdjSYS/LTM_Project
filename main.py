#!/usr/local/bin/python
# GPIO   : RPi.GPIO v3.1.0a  
  
import RPi.GPIO as GPIO  
import time  
GPIO.setmode(GPIO.BCM)
GPIO.setwarnings(False)
  
def readit (Pin):  
  counter = 0  
  # Discharge capacitor  
  GPIO.setup(Pin, GPIO.OUT)  
  GPIO.output(Pin, GPIO.LOW)  
  time.sleep(0.1)  
  GPIO.setup(Pin, GPIO.IN)  
  while(GPIO.input(Pin)==GPIO.LOW):  
        counter =counter+1  
  return counter  
  
# Main program loop  
while True:
    with open("data.txt","w") as f:
        f.write(str(readit(14)))
    time.sleep(1)