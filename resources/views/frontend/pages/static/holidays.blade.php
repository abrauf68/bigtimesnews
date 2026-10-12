@extends('frontend.pages.static.layout')

@section('title', 'US Holiday Calendar')
@section('meta_title', 'US Holiday Calendar: Are Banks, Post Offices & the Stock Market Open? | Big Times News')
@section('meta_description', 'Upcoming US federal holidays with dates and whether banks, the post office and the stock market are open or closed.')
@section('meta_keywords', 'US holidays, bank holidays, stock market holidays, post office closed, federal holidays')
@section('crumb', 'US Holiday Calendar')
@section('heading', 'US Holiday Calendar')
@section('lead', 'Upcoming US holidays and whether banks, the post office and the stock market are open.')

@section('page_body')
    <p>Quick reference for the next holidays. Where a holiday falls on a weekend, observed dates can vary by institution, so we say "Check locally" when it is not certain.</p>
    <div style="overflow-x:auto">
    <table>
        <thead>
            <tr><th>Holiday</th><th>Date</th><th>Banks (Federal Reserve)</th><th>Post Office</th><th>Stock Market (NYSE)</th></tr>
        </thead>
        <tbody>
        @foreach ($rows as $r)
            <tr>
                <td>{{ $r['name'] }}</td>
                <td>{{ $r['date']->format('D, M j, Y') }}</td>
                <td>{{ $r['banks'] }}</td>
                <td>{{ $r['post'] }}</td>
                <td>{{ $r['market'] }}</td>
            </tr>
            @if (!empty($r['note']))
            <tr><td colspan="5"><small>{{ $r['note'] }}</small></td></tr>
            @endif
        @endforeach
        </tbody>
    </table>
    </div>
    <p><small>Always confirm with your bank, local post office or the NYSE for official schedules.</small></p>
@endsection
