# URLShortener

Designing a url shortening service like bit.ly

## Use Cases
The application can be divided into two parts
1. Shortening - take a url => return a much shorter url.
2. Redirection - take a short url => redirect to the corresponding destination url.

We are assuming that our application is dominated by the read operations (90% reads, 10% writes).

##Design

1. Application Service layer (serves the requests)
    For both Shortening and Redirection

2. Data Storage layer
    Using MySQL as our primary RDBMS where we store the mapping of all short urls against the destination urls.
    Using Redis (via the PHPRedis extension) as a caching layer on top of MySQL to enable much faster reads
    due to storage being in memory.
    
    So basically, for all write operations we write first to MySQL and then cache it on Redis for later usage.
    For all redirections, we first go and check if the url mapping exists in Redis. If not, we go and check the
    database and redirect depending on if we found the url mapping or not.
    
 3. For url generation, for now we are randomly constructing a string of length 6 out of a bucket of acceptable
    characters.
    
    We can also use md5 + a random salt, convert it to base 62 and extract 6 characters for the very same purpose
    as well.
   
 4. CSRF token validation has been implemented to avoid CSRF attacks.
 
 5. Used Materialize to come up with a quick interface.
    
##Demo available at 

http://13.59.76.31/

## TO DO

 1. As we scale, traffic will be quite easy to handle, it will be data that is more interesting in this problem. We 
  might have to shard the database or handle redis storage in a more efficient way at a larger scale.
 
 2. Use redis for further analytics/tracking. For example - Things like how many urls are being shortened from a 
 particular ip address are very easy to implement now.
 
 3. Manage sessions better and store them to redis/database.
 
 4. ~~Debug redirection at Htaccess level. For some reason, the redirection to longer urls from url like http://xx.x.x.x/ksahd
 isn't working on EC2. Spent a good 45 minutes to figure it out but in the end took the leeway to use http://xx.x.x.x/index.php?goto=''
 format for now...~~ Fixed this. Was a problem with the mod rewrite configuration on my ec2 instance. Check commit https://github.com/jagjeetdhaliwal/URLShortener/commit/54ad40a6e69543c28f7525f75a6f00136824c779

 5. Add a list of stop words for unacceptable words in urls :-)

