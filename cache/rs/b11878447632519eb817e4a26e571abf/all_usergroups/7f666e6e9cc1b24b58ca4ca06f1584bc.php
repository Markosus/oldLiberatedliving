<?php
/*YToxOntzOjMyOiJiODYzMjNhNzNhNGVjYzY3YmNhMTRmNDFkNzc1MDc5NCI7YToxMDp7aTowO086ODoic3RkQ2xhc3MiOjQ6e3M6MjoiSUQiO3M6MToiOCI7czoxMjoiZGlzcGxheV9uYW1lIjtzOjExOiJbQW5vbnltb3VzXSI7czo4OiJkZXNjcmlwdCI7czozMToiQW5vbnltb3VzIHVzZXJzIChub3QgbG9nZ2VkIGluKSI7czo3OiJtZXRhX2lkIjtzOjc6IndwX2Fub24iO31pOjE7Tzo4OiJzdGRDbGFzcyI6NDp7czoyOiJJRCI7czoxOiI5IjtzOjEyOiJkaXNwbGF5X25hbWUiO3M6Mjc6IltQZW5kaW5nIFJldmlzaW9uIE1vbml0b3JzXSI7czo4OiJkZXNjcmlwdCI7czo3MToiQWRtaW5pc3RyYXRvcnMgLyBQdWJsaXNoZXJzIHRvIG5vdGlmeSAoYnkgZGVmYXVsdCkgb2YgcGVuZGluZyByZXZpc2lvbnMiO3M6NzoibWV0YV9pZCI7czoyODoicnZfcGVuZGluZ19yZXZfbm90aWNlX2VkX25yXyI7fWk6MjtPOjg6InN0ZENsYXNzIjo0OntzOjI6IklEIjtzOjI6IjEwIjtzOjEyOiJkaXNwbGF5X25hbWUiO3M6Mjk6IltTY2hlZHVsZWQgUmV2aXNpb24gTW9uaXRvcnNdIjtzOjg6ImRlc2NyaXB0IjtzOjc4OiJBZG1pbmlzdHJhdG9ycyAvIFB1Ymxpc2hlcnMgdG8gbm90aWZ5IHdoZW4gYW55IHNjaGVkdWxlZCByZXZpc2lvbiBpcyBwdWJsaXNoZWQiO3M6NzoibWV0YV9pZCI7czozMDoicnZfc2NoZWR1bGVkX3Jldl9ub3RpY2VfZWRfbnJfIjt9aTozO086ODoic3RkQ2xhc3MiOjQ6e3M6MjoiSUQiO3M6MToiMSI7czoxMjoiZGlzcGxheV9uYW1lIjtzOjE4OiJbV1AgYWRtaW5pc3RyYXRvcl0iO3M6ODoiZGVzY3JpcHQiO3M6NTI6IkFsbCB1c2VycyB3aXRoIHRoZSBXb3JkUHJlc3MgYWRtaW5pc3RyYXRvciBibG9nIHJvbGUiO3M6NzoibWV0YV9pZCI7czoyMToid3Bfcm9sZV9hZG1pbmlzdHJhdG9yIjt9aTo0O086ODoic3RkQ2xhc3MiOjQ6e3M6MjoiSUQiO3M6MToiMyI7czoxMjoiZGlzcGxheV9uYW1lIjtzOjExOiJbV1AgYXV0aG9yXSI7czo4OiJkZXNjcmlwdCI7czo0NToiQWxsIHVzZXJzIHdpdGggdGhlIFdvcmRQcmVzcyBhdXRob3IgYmxvZyByb2xlIjtzOjc6Im1ldGFfaWQiO3M6MTQ6IndwX3JvbGVfYXV0aG9yIjt9aTo1O086ODoic3RkQ2xhc3MiOjQ6e3M6MjoiSUQiO3M6MToiNCI7czoxMjoiZGlzcGxheV9uYW1lIjtzOjE2OiJbV1AgY29udHJpYnV0b3JdIjtzOjg6ImRlc2NyaXB0IjtzOjUwOiJBbGwgdXNlcnMgd2l0aCB0aGUgV29yZFByZXNzIGNvbnRyaWJ1dG9yIGJsb2cgcm9sZSI7czo3OiJtZXRhX2lkIjtzOjE5OiJ3cF9yb2xlX2NvbnRyaWJ1dG9yIjt9aTo2O086ODoic3RkQ2xhc3MiOjQ6e3M6MjoiSUQiO3M6MToiNiI7czoxMjoiZGlzcGxheV9uYW1lIjtzOjEzOiJbV1AgY3VzdG9tZXJdIjtzOjg6ImRlc2NyaXB0IjtzOjQ3OiJBbGwgdXNlcnMgd2l0aCB0aGUgV29yZFByZXNzIGN1c3RvbWVyIGJsb2cgcm9sZSI7czo3OiJtZXRhX2lkIjtzOjE2OiJ3cF9yb2xlX2N1c3RvbWVyIjt9aTo3O086ODoic3RkQ2xhc3MiOjQ6e3M6MjoiSUQiO3M6MToiMiI7czoxMjoiZGlzcGxheV9uYW1lIjtzOjExOiJbV1AgZWRpdG9yXSI7czo4OiJkZXNjcmlwdCI7czo0NToiQWxsIHVzZXJzIHdpdGggdGhlIFdvcmRQcmVzcyBlZGl0b3IgYmxvZyByb2xlIjtzOjc6Im1ldGFfaWQiO3M6MTQ6IndwX3JvbGVfZWRpdG9yIjt9aTo4O086ODoic3RkQ2xhc3MiOjQ6e3M6MjoiSUQiO3M6MToiNyI7czoxMjoiZGlzcGxheV9uYW1lIjtzOjE3OiJbV1Agc2hvcF9tYW5hZ2VyXSI7czo4OiJkZXNjcmlwdCI7czo1MToiQWxsIHVzZXJzIHdpdGggdGhlIFdvcmRQcmVzcyBzaG9wX21hbmFnZXIgYmxvZyByb2xlIjtzOjc6Im1ldGFfaWQiO3M6MjA6IndwX3JvbGVfc2hvcF9tYW5hZ2VyIjt9aTo5O086ODoic3RkQ2xhc3MiOjQ6e3M6MjoiSUQiO3M6MToiNSI7czoxMjoiZGlzcGxheV9uYW1lIjtzOjE1OiJbV1Agc3Vic2NyaWJlcl0iO3M6ODoiZGVzY3JpcHQiO3M6NDk6IkFsbCB1c2VycyB3aXRoIHRoZSBXb3JkUHJlc3Mgc3Vic2NyaWJlciBibG9nIHJvbGUiO3M6NzoibWV0YV9pZCI7czoxODoid3Bfcm9sZV9zdWJzY3JpYmVyIjt9fX0=*/
?>