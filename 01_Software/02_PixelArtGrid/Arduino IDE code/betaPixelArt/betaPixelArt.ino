#include <OpenWiFi.h>

#include <ESP8266HTTPClient.h>
#include <ESP8266WiFi.h>
#include <WiFiManager.h>

// almost all of this should be in a config file [config.h]
#define DEBUG_MODE
#define BUTTON_PIN  D1
#define BUTTONLOW_PIN D0
#define PROJECT_SHORT_NAME "ICU"
#define SERVER_URL "http://oege.ie.hva.nl/~palr001/icu"
#define CONFIG_SSID "icu"
#define BACKUP_SSID "VGV75198714B3"
#define BACKUP_PASSWORD "wNSY4GMMpzPP"
#define REQUEST_DELAY 800


//add variable for ledstrip color || also add variables for brightness & duration?
boolean isReady = false; // tells the box if it can turn on the ledstrip
int intTimer = 999999999999; // epoch time + 10 [gets the real epoch time + 10 seconds]
int exTimer = 0; // will be equal to the realtime epoch time


int oldTime = 0;
String ChipID;
String serverURL = SERVER_URL;
OpenWiFi hotspot;

void printDebugMessage(String message){
#ifdef DEBUG_MODE
Serial.println(String(PROJECT_SHORT_NAME)+ ":" + message);
#endif
}

void setup()
{
  
  pinMode(BUTTONLOW_PIN, OUTPUT);

  digitalWrite(BUTTONLOW_PIN, LOW);

  Serial.begin(115200); Serial.println("");

  WiFiManager wifiManager;
  int counter = 0;

  pinMode(BUTTON_PIN, INPUT_PULLUP);

  while (digitalRead(BUTTON_PIN) == LOW)
  {
    counter++;
    delay(10);

    if (counter > 500)
    {
      wifiManager.resetSettings();
      printDebugMessage("Remove all wifi settings!");
      ESP.reset();
    }
  }
  hotspot.begin(BACKUP_SSID, BACKUP_PASSWORD);

  ChipID = generateChipID();
  printDebugMessage(String("chipID is: ") + ChipID);
}

void loop()
{

  //Every requestDelay, send a request to the server
  if (millis() > oldTime + REQUEST_DELAY)
  {
    if(isReady != true){
    receiveVariables();
    } else {
      Serial.println("setup complete");
      isTimerSynced();
      if(intTimer <= exTimer){
        Serial.println("LIGHTS SHOULD GO ON NOW");
        intTimer = 0;
        isReady = false;
      }
    }
  oldTime = millis();
  }
}

    String generateChipID()
{
  String chipIDString = String(ESP.getChipId() & 0xffff, HEX);

  chipIDString.toUpperCase();
  while (chipIDString.length() < 4)
    chipIDString = String("0") + chipIDString;

  return chipIDString;
}

    void receiveVariables(){
      HTTPClient http;
  String requestString = serverURL + "/api5.php?t=cnfg&c="+ ChipID +"&o=grdy";
  http.begin(requestString);
  int httpCode = http.GET();
  if (httpCode == 200)
  {
    String response;
    response = http.getString();

    if (response == "-1")
    {
      // I can never get here, buggy stuff
    printDebugMessage("There are no messages waiting in the queue");
    }
    else
    {

       int firstComma = response.indexOf(',');
       int secondComma = response.indexOf(',', firstComma + 1);
 
      // string color = response = gonna be the color you receiver for you chipid
      String color = response.substring(0, 5);
      String ready = response.substring(firstComma + 1, secondComma);
      String internalTimer = response.substring(secondComma + 1, response.length());
      intTimer = internalTimer.toInt();
      Serial.println(intTimer);
     // save String color into a variable color
      if (ready == "1"){
        isReady = true;
      }
    }
  }
    }
    
    void isTimerSynced()
    {
     HTTPClient http;
     String requestString = serverURL + "/epochtime.php";
     http.begin(requestString);
     int httpCode = http.GET();
       if (httpCode == 200)
       {
        String response;
        response = http.getString();
           if (response != "-1")
           {
             String externalTimer = response.substring(0, response.length());
             exTimer = externalTimer.toInt();
           }
       }
    }

