#!/usr/local/bin/perl

## this loads the standard Perl CGI module
use CGI;

## edit this definition to specify the absolute path to
## a Java interpreter on you system.  Note, you need to use 
## the right kind of path separators for your OS. Also,
## in a Perl string, the Windows path separator must be escaped.

# my $JAVA = "c:\\jdk1.3.1\\bin\\java";     #typical windows path
my $JAVA = "/usr/local/jdk1.3.1/bin/java";  #typical unix path

## Under Unix, you may need to edit and uncomment these lines.
## See Equation Server Main Ideas: Connecting to the X Server for details
# $ENV{DISPLAY} = ":0.0;
# $ENV{XAUTHORITY} = "/home/www/.Xauthority";

## The following lines are a standard Perl idiom for retrieving
## the 'eq' argument passed to the script by popup.html
my $query = new CGI;
my $eq = $query->param("eq");

## in most server environments, the following statement will write
## a message into the Web server error log
print STDERR "eq = ".$eq."\n";

## Now we assemble the command line arguments for the Equation Server
## You will have to edit the pathnames below to reflect the actual
## environment on your server.  Note that quotes contained in Perl
## strings must be escaped.  We provide typical Unix and Windows 
## command strings:

## Typical Unix command string:
$cmd =  "$JAVA webeq.wizard.Equation Server ";        # invokes the Equation Server
$cmd .= "-keyfile /home/webeq/.webeqrc ";             # keyfile location
$cmd .= "-bg \"#ffffff\" -padding 5 ";                # background color and padding
$cmd .= "-errors /htmlfiles/tmp/errors ";             # file for error output
$cmd .= "-outtype Images_Only -imgtype png "          # specifies image output
$cmd .= "-imgname \"test\" -o /htmlfiles/tmp/junk ";  # specifies output file names
$cmd .= "-eq \"$eq\"";                                # the equation to convert

## Typical Windows command string:
# $cmd =  "$JAVA webeq.wizard.Equation Server ";
# $cmd .= "-keyfile \\webeq\\.webeqrc ";        
# $cmd .= "-bg \"#ffffff\" -padding 5 ";        
# $cmd .= "-errors \\home\\webeq\\tmp\\errors.txt ";
# $cmd .= "-outtype Images_Only -imgtype png "      
# $cmd .= "-imgname \"test\" -o \\home\\webeq\\tmp\\junk ";
# $cmd .= "-eq \"$eq\"";                                   

## This call executes the Equation Server command
system($cmd);

## The remainder of the script generate the HTML to return
## Note that the path to the image file in the HTML must correspond 
## to the output directory and image name you specified in the 
## Equation Server command
print $query->header();
print qq|
<html><body>
<h1>Test page</h1>
<p>Here is your equation as an image:
<img src="tmp/test.gif" align="absmiddle"></p>
</body></html>
|;

