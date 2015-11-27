# 15.1 - The dynamic algorithm for finding change

def dynamic_coin_changing(C, k):
   n = len(C)
   # create two-dimensional array with all zeros
   dp = [[0] * (k + 1) for i in xrange(n + 1)]

   print dp

   dp[0] = [0] + [MAX_INT] * k

   print dp

   for i in xrange(1, n + 1):
      for j in xrange(C[i - 1]):
         dp[i][j] = dp[i - 1][j]
      for j in xrange(C[i - 1], k + 1):
         dp[i][j] = min(dp[i][j - C[i - 1]] + 1, dp[i - 1][j])


   print dp


   return dp[n]
