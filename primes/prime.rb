###
# This is a pretty straight-foward script utilizing
# Ruby's Prime class and regular expressions to
# find the 333rd prime number beginning and ending
# with the number 3
require 'prime'

count = 0
(1..399993).each do |n|
   if (n.prime? and n.to_s.match('^[3](\d)*[3]$'))
      count = count + 1
      if (count == 333)
         puts "The 333rd prime number beginning and ending with\n"
         puts "a 3 is #{n}."
      end
   end
end
