terraform {
  required_providers {
    aws ={
        source = "hashicorp/aws"
        version = "~> 5.0"
    }
  }
}
provider "aws" {
    region = "us-east-1"
}

resource "aws_s3_bucket" "s3" {
    bucket = "mi-bucket-gabriel-2"
}
resource "aws_s3_bucket_public_access_block" "s3_conf" {
    bucket = aws_s3_bucket.terraform_state.id
    block_public_acls = false
    block_public_policy = false
    ignore_public_acls = false
    restrict_public_buckets = false
}
resource "aws_s3_bucket_policy" "politica" {
    bucket = aws_s3_bucket.terraform_state.id
    policy = <<JSON
    {
    "Version":"2012-10-17",
    "Statement":[
    {
     "Effect" "Allow"
     "Principal":"*"
     "Action":"s3:GetObject",
     "Resource":"arn:aws:s3:::mi-bucket-gabriel-2/*"
    }
    ]
    
    }
    JSON 
    depends_on = [  aws_s3_bucket_public_access_block.s3_conf ]    
}