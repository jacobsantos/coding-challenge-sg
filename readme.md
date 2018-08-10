# Problem 1
## Description
Given a list of people with their birth and end years (all between 1900 and 2000), find the year with the most number of people alive.
## Code
Solve using a language of your choice and dataset of your own creation.
## Submission

Please upload your code, dataset, and example of the program’s output to Bit Bucket or Github. Please include any graphs or charts created by your program.


# Problem 2: Implement a basic spin results end point
##Description
Slot Machine Spin Results is our server end point that updates all player data and features when a spin is completed on the client. We do hundreds of millions of these requests per day, and we would like to see you make a very basic MySQL driven version.
This can be just a normal PHP file that gets called, or you can implement more modern routing if you would like
## Data Storage
Create a MySQL database that contains a player table with the following fields:
* Player ID
* Name
* Credits
* Lifetime Spins
* Salt Value
## Code
1. Your code should validate the following request data:
    * hash
    * coins won
    * coins bet
    * player ID
1. Update the player data in MySQL if the data is valid
1. Generate a JSON response with the following data:
    * Player ID
    * Name
    * Credits
    * Lifetime Spins
    * Lifetime Average Return
You can assume that the client making the request has the salt value to make the hash.
## Submission
Please upload your code and MySQL schema to either Bit Bucket or Github