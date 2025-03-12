import { test, expect } from '@playwright/test';
import { faker } from '@faker-js/faker';

const PASSWORD = 'Abcd@1234';

test.beforeEach(async ({ page }) => {
    await page.goto('http://127.0.0.1:8000/');
});

test.describe('Register Tests', () => {
    test('register a new user', async ({ page }) => {
        const randomName = faker.person.fullName();
        const randomEmail = faker.internet.email();

        await test.step('Navigate to registration page', async () => {
            await page.getByRole('link', { name: 'Register' }).click();
            await expect(page.getByRole('textbox', { name: 'Name' })).toBeVisible();
        });

        await test.step('Fill out registration form', async () => {
            await page.getByRole('textbox', { name: 'Name' }).fill(randomName);
            await page.getByRole('textbox', { name: 'Email' }).fill(randomEmail);
            await page.getByRole('textbox', { name: 'Password', exact: true }).fill(PASSWORD);
            await page.getByRole('textbox', { name: 'Confirm Password' }).fill(PASSWORD);
        });

        await test.step('Submit registration form', async () => {
            await page.getByRole('button', { name: 'Register' }).click();
        });

        await test.step('Verify registration success', async () => {
            await expect(page.locator('body')).toContainText('Dashboard');
        });
    });

    test('register duplicated user', async ({ page }) => {
        const randomName = faker.person.fullName();
        const randomEmail = faker.internet.email();

        await test.step('Navigate to registration page', async () => {
            await page.getByRole('link', { name: 'Register' }).click();
            await expect(page.getByRole('textbox', { name: 'Name' })).toBeVisible();
        });

        await test.step('Fill out registration form', async () => {
            await page.getByRole('textbox', { name: 'Name' }).fill(randomName);
            await page.getByRole('textbox', { name: 'Email' }).fill(randomEmail);
            await page.getByRole('textbox', { name: 'Password', exact: true }).fill(PASSWORD);
            await page.getByRole('textbox', { name: 'Confirm Password' }).fill(PASSWORD);
        });

        await test.step('Submit registration form', async () => {
            await page.getByRole('button', { name: 'Register' }).click();
        });

        await test.step('Verify registration success', async () => {
            await expect(page.locator('body')).toContainText('Dashboard');
        });

        await test.step('Logout', async () => {
            await page.locator('#user-button').click();
            await page.getByRole('link', { name: 'Log Out' }).click();
        });

        await test.step('Navigate to registration page', async () => {
            await page.getByRole('link', { name: 'Register' }).click();
            await expect(page.getByRole('textbox', { name: 'Name' })).toBeVisible();
        });

        await test.step('Fill out registration form', async () => {
            await page.getByRole('textbox', { name: 'Name' }).fill(randomName);
            await page.getByRole('textbox', { name: 'Email' }).fill(randomEmail);
            await page.getByRole('textbox', { name: 'Password', exact: true }).fill(PASSWORD);
            await page.getByRole('textbox', { name: 'Confirm Password' }).fill(PASSWORD);
        });

        await test.step('Submit registration form', async () => {
            await page.getByRole('button', { name: 'Register' }).click();
        });

        await test.step('Verify registration failure', async () => {
            await expect(page.locator('body')).toContainText('The email has already been taken.');
        });
    });
});