# 15.1 - The dynamic algorithm for finding change

def dynamic_coin_changing(C, k):
   n = len(C)
   # create two-dimensional array with all zeros
   dp = [[0] * (k + 1) for i in xrange(n + 1)]

   print "1st dp";
   print dp

   # set first row of "infinite" values (see documentation)
   dp[0] = [0] + ["MAX_INT"] * k

   print "dp after funky arithmetic"
   print dp


                                                                        # PHP equiv:

   for i in xrange(1, n + 1):                                           #  for ($i = 1; $i <= (3 + 1); $i++) { 
      for j in xrange(C[i - 1]):                                        #     for ($j = 0; $j <= $c[$i - 1]; $j++)
         dp[i][j] = dp[i - 1][j]                                        #        $dp[$i][$j] = $dp[$i - 1][$j]
      for j in xrange(C[i - 1], k + 1):                                 #     for ($j = $C[$i - 1]; $j <= ($k + 1); $j++) 
         dp[i][j] = min(dp[i][j - C[i - 1]] + 1, dp[i - 1][j])          #        $dp[$i][$j] = min($dp[$i][$j - $C[$i - 1]] + 1, $dp[$i - 1][$j]
                                                                        #


   print dp


   return dp[n]

answer = dynamic_coin_changing([1,3,4], 6)
print "answer"
print answer
