# Capture the CAPTCHA Demo
## Table of Contents
- [Capture the CAPTCHA Demo](#capture-the-captcha-demo)
  - [Table of Contents](#table-of-contents)
    - [Description](#description)
    - [Limitations](#limitations)
    - [Installation](#installation)
    - [Acknowledgments](#acknowledgments)

### Description
The Capture the CAPTCHA Demo is part of a presentation given by George Wood as part of his graduate course work at the University of Texas at El Paso (UTEP).

The purpose of this Demo is to provide a proof of concept and motivating example of security concerns related to the use and by pass of CAPTCHAs.

This Demo is self contained and works by executing PHP and Python code hosted within a Docker container and echoing it to the browser as plain text.

PHP and Python source code is found under www/captcha/

The Capture the CAPTCHA Demo consists of a Docker-Compose Container utilizing:
* PHP 7.2
* Python 2.7
* PIL 1.1.7

### Limitations
The source code contained herein is for demonstration purposes only.  As such, much of the Python code that solves CAPTCHAs contain many hard coded elements.  

The dynamic CAPTCHA Solver script (solver.py) is able to 'learn' different CAPTCHAs through repeated exposure.  However, the categorization of learning data and text identification parameters are wholly manual.

### Installation

Clone this repository on your local computer and `docker-compose up -d`.

    ```shell
    git clone https://github.com/drpresq/capture-the-captcha.git
    cd capture-the-captcha/
    cp sample.env .env
    docker-compose up -d
    ```
You can access the website via `http://localhost`.

### Acknowledgments

My thanks to those with vast knowledge, talent, and experience whose work assisted me with this short Demo.

Code based on original works by:
* Dr. Ben Boyter (https://boyter.org/decoding-captchas/)
* Rahul Sasi (http://garage4hackers.com/entry.php?b=3103)
* Narendra Vaghela (https://github.com/sprintcube/docker-compose-lamp)

Inspired by:
* Mark Baggett (https://www.sans.org/instructors/mark-baggett)
* Joff Thyer (https://www.linkedin.com/in/joffthyer/)
* SANS SEC573 Python for Penetration Testers