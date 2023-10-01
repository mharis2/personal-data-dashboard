use strict;
use warnings;
use Text::CSV;

my $input_file = '../data/input/uploaded.csv';  # Correct the path
my $output_file = '../data/output/processed.csv';  # The path for this seems to be correct

open my $in, '<', $input_file or die "Cannot open $input_file: $!";
open my $out, '>', $output_file or die "Cannot open $output_file: $!";

my $csv = Text::CSV->new({binary => 1});
print "Script started\n";

while (my $row = $csv->getline($in)) {
    $csv->print($out, $row);
    print $out "\n";
}
print "Script finished\n";

close $in;
close $out;
