require 'prime'

count = 0
(1..313853).each do |n|
   if (n.prime? and n.to_s.match('^[3](\d)*[3]$'))
      count = count + 1
#      if (count == 333)
         p "#{count} #{n}"
#      end
   end
end
