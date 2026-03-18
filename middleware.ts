export const config = {
  matcher: '/:path*',
};

export default function middleware(request: Request) {
  const country =
    request.headers.get('x-vercel-ip-country') || '';

  console.log('Country:', country);

  if (country === 'VN') {
    return Response.redirect(new URL('https://www.google.com'));
  }

  return;
}